<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CallKestari extends Model
{
    use HasFactory;

    protected $table = 'call_kestaris';
    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'appear' => 'string',
    ];

    /**
     * Get table configuration for admin index table component
     */
    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'No Call Kestari data found',
            'emptyIcon' => 'fa-phone',
            'colspan' => 5,
            'columns' => [
                [
                    'key' => 'buttonName',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'link',
                    'type' => 'link',
                    'fallback' => 'No link',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'created_at',
                    'type' => 'datetime',
                    'dateFormat' => 'DD MMMM YYYY',
                    'timeFormat' => 'H:i',
                    'fallback' => 'Undefined',
                    'class' => 'text-center',
                ],
            ],
            'actions' => [
                'view' => [
                    'enabled' => true,
                    'route' => 'admin.service.callkestari.show',
                    'routeKey' => 'id',
                ],
                'edit' => [
                    'enabled' => true,
                    'type' => 'link',
                    'route' => 'admin.service.callkestari.edit',
                    'routeKey' => 'id',
                ],
                'delete' => [
                    'enabled' => true,
                    'btnClass' => 'delete-callkestari-btn',
                ],
            ],
        ];
    }

    /**
     * Search and filter call kestari for admin panel with pagination
     */
    public static function searchAdminCallKestari(Request $request)
    {
        $query = self::query();

        // Search by button name
        if ($request->filled('buttonName')) {
            $query->where('buttonName', 'like', '%' . $request->buttonName . '%');
        }

        // Search by link
        if ($request->filled('link')) {
            $query->where('link', 'like', '%' . $request->link . '%');
        }

        // Filter by appear status
        if ($request->filled('appear')) {
            $query->where('appear', $request->appear);
        }

        // Filter by date range
        if ($request->filled('created_at')) {
            $dates = explode(' - ', $request->created_at);
            if (count($dates) == 2) {
                try {
                    $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[0]))->startOfDay();
                    $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    // Invalid date format, skip filter
                }
            }
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        $allowedSorts = ['buttonName', 'link', 'appear', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate(15)->appends($request->query());
    }

    /**
     * Get all appear options for filter dropdown
     */
    public static function getAppearOptions()
    {
        return [
            'Up' => 'Up',
            'Down' => 'Down',
        ];
    }

    /**
     * Validate request for store/update
     */
    public static function validateRequest(Request $request, $id = null)
    {
        return $request->validate([
            'buttonName' => 'required|string|max:255',
            'link' => 'required|url|max:500',
            'appear' => 'required|in:Up,Down',
        ]);
    }

    /**
     * Save new call kestari
     */
    public static function saveModel(Request $request): self
    {
        return self::create([
            'buttonName' => $request->buttonName,
            'link' => $request->link,
            'appear' => $request->appear,
        ]);
    }

    /**
     * Update existing call kestari
     */
    public function updateModel(Request $request): self
    {
        $this->update([
            'buttonName' => $request->buttonName,
            'link' => $request->link,
            'appear' => $request->appear,
        ]);

        return $this;
    }

    /**
     * Delete call kestari
     */
    public function deleteModel(): bool
    {
        return $this->delete();
    }

    /**
     * Bulk delete call kestari
     */
    public static function bulkDeleteModel(array $ids): int
    {
        return self::whereIn('id', $ids)->delete();
    }
}
