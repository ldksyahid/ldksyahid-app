<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LkGeneration extends Model
{
    protected $table = 'lk_generation';

    protected $fillable = [
        'year',
        'generationName',
    ];

    public $timestamps = false;

    public function getKtaData()
    {
        return $this->hasMany(MsKTALDKSyahid::class, 'generationID', 'id');
    }

    /**
     * Accessor: count of KTA members associated with this generation
     */
    public function getKtaMembersCountAttribute(): int
    {
        return (int) ($this->attributes['get_kta_data_count'] ?? $this->getKtaData()->count());
    }

    /**
     * Accessor: whether this generation has any associated KTA members
     */
    public function getHasKtaMembersAttribute(): bool
    {
        return $this->kta_members_count > 0;
    }

    /**
     * Get table configuration for admin index table component
     */
    public static function getTableConfig(): array
    {
        return [
            'idKey'        => 'id',
            'emptyMessage' => 'No Generation data found',
            'emptyIcon'    => 'fa-graduation-cap',
            'colspan'      => 5,
            'columns'      => [
                [
                    'key'   => 'year',
                    'type'  => 'text',
                    'class' => 'text-center fw-bold',
                ],
                [
                    'key'   => 'generationName',
                    'type'  => 'text',
                    'class' => 'text-center',
                ],
            ],
            'actions' => [
                'edit' => [
                    'enabled'   => true,
                    'type'      => 'modal',
                    'class'     => 'btn-custom-primary',
                    'modalData' => [
                        'id'   => 'id',
                        'year' => 'year',
                        'name' => 'generationName',
                    ],
                ],
                'delete' => [
                    'enabled'                => true,
                    'class'                  => 'btn-custom-primary',
                    'btnClass'               => 'delete-generation-btn',
                    'disabledConditionField' => 'has_kta_members',
                    'disabledConditionTitle' => 'Cannot delete: this generation is currently used by KTA member(s)',
                ],
            ],
        ];
    }

    /**
     * Search and filter generations for admin panel with pagination
     */
    public static function searchAdminGeneration(Request $request)
    {
        $query = self::query()->withCount('getKtaData');

        if ($request->filled('year')) {
            $query->where('year', 'like', '%' . $request->year . '%');
        }

        if ($request->filled('generationName')) {
            $query->where('generationName', 'like', '%' . $request->generationName . '%');
        }

        $sortBy = $request->input('sort_by', 'year');
        $sortOrder = $request->input('sort_order', 'desc');

        $allowedSorts = ['year', 'generationName', 'id'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'year';
        }

        $generations = $query->orderBy($sortBy, $sortOrder)->paginate(15);

        // Ensure has_kta_members is populated on each model instance
        $generations->getCollection()->transform(function ($item) {
            $item->has_kta_members = ($item->get_kta_data_count ?? 0) > 0;
            return $item;
        });

        return $generations;
    }
}
