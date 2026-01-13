<?php

namespace App\Models;

use AshAllenDesign\ShortURL\Models\ShortURL;
use AshAllenDesign\ShortURL\Models\ShortURLVisit;
use AshAllenDesign\ShortURL\Classes\Builder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MsShortlink extends ShortURL
{
    protected $table = 'short_urls';

    /**
     * Allowed sort columns
     */
    protected static array $allowedSorts = [
        'url_key',
        'destination_url',
        'default_short_url',
        'created_by',
        'created_at',
        'visits_count'
    ];

    /**
     * Table configuration for admin-index component
     */
    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'No shortlinks found',
            'emptyIcon' => 'fa-link',
            'colspan' => 9,
            'columns' => [
                [
                    'key' => 'url_key',
                    'type' => 'url-key',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'destination_url',
                    'type' => 'destination-link',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'url_key',
                    'type' => 'shortlink',
                    'class' => 'text-start',
                    'urlKeyField' => 'url_key',
                ],
                [
                    'key' => 'visits_count',
                    'type' => 'text',
                    'class' => 'text-center',
                    'fallback' => '0',
                ],
                [
                    'key' => 'created_at',
                    'type' => 'datetime',
                    'class' => 'text-center',
                    'dateFormat' => 'DD MMMM YYYY',
                    'timeFormat' => 'H:i T',
                ],
                [
                    'key' => 'created_by',
                    'type' => 'text',
                    'class' => 'text-center',
                    'fallback' => 'Undefined',
                ],
            ],
            'actions' => [
                'edit' => [
                    'enabled' => true,
                    'type' => 'modal',
                    'class' => 'btn-primary',
                    'modalData' => [
                        'id' => 'id',
                        'url' => 'url_key',
                        'destination' => 'destination_url',
                    ],
                ],
                'delete' => [
                    'enabled' => true,
                    'class' => 'btn-primary',
                    'btnClass' => 'delete-btn',
                    'superadminOnly' => true,
                ],
            ],
        ];
    }

    /**
     * Search shortlinks for admin (alias for getPaginated)
     */
    public static function searchAdminShortlink(Request $request, int $perPage = 15)
    {
        return static::getPaginated($request, $perPage);
    }

    /**
     * Get paginated shortlinks with filters
     */
    public static function getPaginated(Request $request, int $perPage = 15)
    {
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        if (!in_array($sortBy, static::$allowedSorts)) {
            $sortBy = 'created_at';
        }

        return static::withCount('visits')
            ->when($request->filled('url_key'), function ($query) use ($request) {
                $query->where('url_key', 'like', '%' . $request->url_key . '%');
            })
            ->when($request->filled('destination_url'), function ($query) use ($request) {
                $query->where('destination_url', 'like', '%' . $request->destination_url . '%');
            })
            ->when($request->filled('default_short_url'), function ($query) use ($request) {
                $query->where('default_short_url', 'like', '%' . $request->default_short_url . '%');
            })
            ->when($request->filled('created_by'), function ($query) use ($request) {
                $query->where('created_by', 'like', '%' . $request->created_by . '%');
            })
            ->when($request->filled('visits_range'), function ($query) use ($request) {
                $range = $request->visits_range;

                if ($range === '1001+') {
                    $query->having('visits_count', '>=', 1001);
                } else {
                    list($min, $max) = explode('-', $range);
                    $query->having('visits_count', '>=', $min)
                        ->having('visits_count', '<=', $max);
                }
            })
            ->when($request->filled('created_at'), function ($query) use ($request) {
                $dates = explode(' - ', $request->created_at);
                if (count($dates) === 2) {
                    $start = Carbon::createFromFormat('d-m-Y', trim($dates[0]))->startOfDay();
                    $end = Carbon::createFromFormat('d-m-Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('created_at', [$start, $end]);
                }
            })
            ->when($request->filled('created_at_start') && $request->filled('created_at_end'), function ($query) use ($request) {
                $start = Carbon::createFromFormat('d-m-Y', $request->created_at_start)->startOfDay();
                $end = Carbon::createFromFormat('d-m-Y', $request->created_at_end)->endOfDay();
                $query->whereBetween('created_at', [$start, $end]);
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate($perPage)
            ->appends($request->all());
    }

    /**
     * Create a new shortlink
     */
    public static function createShortlink(string $destinationUrl): array
    {
        $validator = Validator::make(['url' => $destinationUrl], [
            'url' => 'required|url'
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors(),
                'status' => 422
            ];
        }

        $builder = new Builder();
        $shortURLObject = $builder->destinationUrl($destinationUrl)->make();

        return [
            'success' => true,
            'message' => 'URL shortened successfully.',
            'data' => $shortURLObject
        ];
    }

    /**
     * Update an existing shortlink
     */
    public static function updateShortlink(int $id, string $urlKey, string $destinationUrl): array
    {
        $validator = Validator::make([
            'url' => $urlKey,
            'destination' => $destinationUrl
        ], [
            'url' => [
                'required',
                'string',
                'alpha_dash',
                Rule::unique('short_urls', 'url_key')->ignore($id),
            ],
            'destination' => 'required|url',
        ], [
            'url.required' => 'URL Key is required.',
            'url.alpha_dash' => 'URL Key may only contain letters, numbers, dashes, and underscores.',
            'url.unique' => 'This URL Key is already taken. Please choose another.',
            'destination.required' => 'Destination URL is required.',
            'destination.url' => 'The destination must be a valid URL.',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors(),
                'status' => 422
            ];
        }

        $shortlink = static::findOrFail($id);
        $shortlink->url_key = $urlKey;
        $shortlink->destination_url = $destinationUrl;
        $shortlink->default_short_url = config('app.url') . '/' . $urlKey;
        $shortlink->save();

        return [
            'success' => true,
            'message' => 'URL updated successfully.',
            'data' => $shortlink
        ];
    }

    /**
     * Delete a shortlink and its visits
     */
    public static function deleteShortlink(int $id): array
    {
        $shortlink = static::findOrFail($id);
        ShortURLVisit::where('short_url_id', $shortlink->id)->delete();
        $shortlink->delete();

        return [
            'success' => true,
            'message' => 'URL deleted successfully.'
        ];
    }

    /**
     * Bulk delete shortlinks
     */
    public static function bulkDeleteShortlinks(array $ids): array
    {
        if (empty($ids)) {
            return [
                'success' => false,
                'message' => 'No items selected for deletion.',
                'status' => 400
            ];
        }

        ShortURLVisit::whereIn('short_url_id', $ids)->delete();
        static::whereIn('id', $ids)->delete();

        return [
            'success' => true,
            'message' => 'Selected shortlinks have been deleted!'
        ];
    }
}
