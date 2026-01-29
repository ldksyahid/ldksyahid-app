<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ReqShortlink extends Model
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
        'whatsapp',
        'customLink',
        'created_at',
    ];

    /**
     * Get table configuration for admin index table component
     */
    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'No request shortlink found',
            'emptyIcon' => 'fa-link',
            'colspan' => 9,
            'columns' => [
                [
                    'key' => 'name',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'whatsapp',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'customLink',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'fixCustomLink',
                    'type' => 'link',
                    'class' => 'text-center',
                    'fallback' => 'Not Set',
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
                    'route' => 'admin.reqservice.shortlink.show',
                    'routeKey' => 'id',
                ],
                'edit' => [
                    'enabled' => true,
                    'type' => 'link',
                    'route' => 'admin.reqservice.shortlink.edit',
                    'routeKey' => 'id',
                ],
                'delete' => [
                    'enabled' => true,
                    'btnClass' => 'delete-reqshortlink-btn',
                ],
                'custom' => [
                    [
                        'enabled' => true,
                        'icon' => 'fa-paper-plane',
                        'class' => 'btn-primary',
                        'title' => 'Send via WhatsApp',
                        'target' => '_blank',
                        'urlBuilder' => function ($item) {
                            $adminName = \Illuminate\Support\Facades\Auth::user()->name ?? '';
                            return "https://api.whatsapp.com/send?phone={$item->whatsapp}&text="
                                . urlencode("*[KUSTOM URL KAMU SUDAH JADI]*\n\n_Assalammu'alaikum_\n\nHalo {$item->name} 😀, Perkenalkan Saya _{$adminName}_, Berikut hasil link yang telah kami Kustom menggunakan layanan kami :\n\n{$item->fixCustomLink}\n\n**Link Tersebut Wajib digunakan dengan Sebagaimana Mestinya*\n\nTerimakasih {$item->name} karena telah menggunakan layanan kami 😉\n\n_Wassalammua'laikum_\n\n#KitaAdalahSaudara\n#LDKSyahid\n#PijarAskara\n#UINJakarta");
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * Get unique name options for select2 filter
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
     * Get fix custom link status options for select2 filter
     */
    public static function getStatusOptions(): array
    {
        return [
            'completed' => 'Completed',
            'pending' => 'Pending',
        ];
    }

    /**
     * Search and filter request shortlinks for admin panel with pagination
     */
    public static function searchAdminReqShortlinks(Request $request)
    {
        $query = self::query();

        // Search by name
        if ($request->filled('name')) {
            $query->where('name', $request->name);
        }

        // Filter by status (fixCustomLink filled or not)
        if ($request->filled('status')) {
            if ($request->status === 'completed') {
                $query->whereNotNull('fixCustomLink')->where('fixCustomLink', '!=', '');
            } elseif ($request->status === 'pending') {
                $query->where(function ($q) {
                    $q->whereNull('fixCustomLink')->orWhere('fixCustomLink', '');
                });
            }
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
     * Update model with fix custom link
     */
    public function updateModel(Request $request): self
    {
        $this->update([
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'defaultLink' => $request->defaultLink,
            'customLink' => $request->customLink,
            'note' => $request->note,
            'fixCustomLink' => $request->fixCustomLink,
        ]);

        return $this;
    }

    /**
     * Delete request shortlink
     */
    public function deleteModel(): bool
    {
        return $this->delete();
    }

    /**
     * Bulk delete request shortlinks
     */
    public static function bulkDeleteModel(array $ids): int
    {
        return self::whereIn('id', $ids)->delete();
    }
}
