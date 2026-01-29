<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MessageContact extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Allowed sort columns
     */
    protected static array $allowedSorts = [
        'name',
        'email',
        'subject',
        'created_at',
    ];

    /**
     * Get table configuration for admin index table component
     */
    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'No contact messages found',
            'emptyIcon' => 'fa-envelope',
            'colspan' => 7,
            'columns' => [
                [
                    'key' => 'name',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'email',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'subject',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'created_at',
                    'type' => 'datetime',
                    'class' => 'text-center',
                    'dateFormat' => 'DD MMMM YYYY',
                    'timeFormat' => 'H:i T',
                ],
            ],
            'actions' => [
                'view' => [
                    'enabled' => true,
                    'route' => 'admin.about.contact.show',
                    'routeKey' => 'id',
                ],
                'edit' => [
                    'enabled' => false,
                ],
                'delete' => [
                    'enabled' => true,
                    'btnClass' => 'delete-message-btn',
                ],
            ],
        ];
    }

    /**
     * Get unique names for select2 filter
     */
    public static function getNameOptions(): array
    {
        return self::select('name')
            ->distinct()
            ->orderBy('name')
            ->pluck('name', 'name')
            ->filter()
            ->toArray();
    }

    /**
     * Get unique subjects for select2 filter
     */
    public static function getSubjectOptions(): array
    {
        return self::select('subject')
            ->distinct()
            ->orderBy('subject')
            ->pluck('subject', 'subject')
            ->filter()
            ->toArray();
    }

    /**
     * Search and filter messages for admin panel with pagination
     */
    public static function searchAdminMessages(Request $request)
    {
        $query = self::query();

        // Search by name
        if ($request->filled('name')) {
            $query->where('name', $request->name);
        }

        // Search by subject
        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }

        // Filter by created date range
        if ($request->filled('created_at_start') && $request->filled('created_at_end')) {
            $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->created_at_start)->startOfDay();
            $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->created_at_end)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        if (!in_array($sortBy, static::$allowedSorts)) {
            $sortBy = 'created_at';
        }

        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate(15)->appends($request->query());
    }

    /**
     * Delete message
     */
    public function deleteModel(): bool
    {
        return $this->delete();
    }

    /**
     * Bulk delete messages
     */
    public static function bulkDeleteModel(array $ids): int
    {
        return self::whereIn('id', $ids)->delete();
    }
}
