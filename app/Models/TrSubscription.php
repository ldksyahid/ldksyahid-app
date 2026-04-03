<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TrSubscription extends Model
{
    use HasFactory;

    protected $table = 'tr_subscription';
    protected $primaryKey = 'subscriberID';
    public $timestamps = false;

    protected $fillable = [
        'email',
        'flagActive',
        'subscribedDate',
        'unsubscribedDate',
        'createdDate',
        'editedDate',
    ];

    protected $casts = [
        'flagActive' => 'boolean',
        'subscribedDate' => 'datetime',
        'unsubscribedDate' => 'datetime',
        'createdDate' => 'datetime',
        'editedDate' => 'datetime',
    ];

    /**
     * Get table name
     */
    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    /**
     * Attribute Labels
     */
    public static function attributeLabels(): array
    {
        return [
            'subscriberID' => 'Subscriber ID',
            'email' => 'Email',
            'flagActive' => 'Active',
            'subscribedDate' => 'Subscribed Date',
            'unsubscribedDate' => 'Unsubscribed Date',
            'createdDate' => 'Created Date',
            'editedDate' => 'Edited Date',
        ];
    }

    /**
     * Booted events (auto set created & edited)
     */
    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->createdDate = now();
            $model->editedDate = now();
            $model->subscribedDate = now();
            $model->flagActive = true;
        });

        static::updating(function ($model) {
            $model->editedDate = now();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    public static function validateRequest(Request $request, $ignoreId = null): array
    {
        $table = self::getTableName();

        $rules = [
            'email' => 'required|email|max:255',
        ];

        if ($ignoreId === null) {
            $rules['email'] .= "|unique:$table,email";
        } else {
            $rules['email'] .= "|unique:$table,email,$ignoreId,subscriberID";
        }

        return $request->validate($rules, [
            'email.required' => 'Email wajib diisi!',
            'email.email'    => 'Format email tidak valid!',
            'email.unique'   => 'Email ini sudah terdaftar sebagai langganan kami!',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic
    |--------------------------------------------------------------------------
    */

    /**
     * Subscribe email
     */
    public static function subscribe(Request $request): array
    {
        try {
            self::validateRequest($request);

            self::create([
                'email' => $request->email,
                'flagActive' => true,
                'subscribedDate' => now(),
            ]);

            return [
                'success' => true,
                'message' => 'Terima kasih! Email Anda berhasil didaftarkan untuk berlangganan kepada kami. 🎉',
            ];
        } catch (\Illuminate\Validation\ValidationException $e) {
            return [
                'success' => false,
                'errors' => $e->errors(),
                'message' => $e->getMessage(),
                'status' => 422,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'errors' => ['email' => ['Terjadi kesalahan saat mendaftarkan email.']],
                'message' => $e->getMessage(),
                'status' => 500,
            ];
        }
    }

    /**
     * Unsubscribe email
     */
    public static function unsubscribe(Request $request): array
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ], [
                'email.required' => 'Email wajib diisi!',
                'email.email' => 'Format email tidak valid!',
            ]);

            $subscription = self::where('email', $request->email)
                               ->where('flagActive', true)
                               ->first();

            if (!$subscription) {
                return [
                    'success' => false,
                    'errors' => ['email' => ['Email tidak ditemukan di daftar pelanggan kami.']],
                    'message' => 'Email tidak ditemukan di daftar pelanggan kami.',
                    'status' => 404,
                ];
            }

            $subscription->update([
                'flagActive' => false,
                'unsubscribedDate' => now(),
            ]);

            return [
                'success' => true,
                'message' => 'Anda berhasil berhenti berlangganan dari kami.',
            ];
        } catch (\Illuminate\Validation\ValidationException $e) {
            return [
                'success' => false,
                'errors' => $e->errors(),
                'message' => $e->getMessage(),
                'status' => 422,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'errors' => ['email' => ['Terjadi kesalahan saat membatalkan langganan.']],
                'message' => $e->getMessage(),
                'status' => 500,
            ];
        }
    }

    /**
     * Reactivate subscription
     */
    public function reactivate(): void
    {
        $this->update([
            'flagActive' => true,
            'unsubscribedDate' => null,
        ]);
    }

    /**
     * Admin - add multiple emails at once (textarea input).
     * Returns summary array: added, skipped, invalid.
     */
    public static function addMultiple(string $rawInput): array
    {
        $lines  = preg_split('/[\r\n,]+/', $rawInput);
        $emails = array_filter(array_map('trim', $lines));

        $added   = 0;
        $skipped = [];
        $invalid = [];

        foreach ($emails as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $invalid[] = $email;
                continue;
            }

            $existing = self::where('email', $email)->first();

            if ($existing) {
                if (!$existing->flagActive) {
                    $existing->reactivate();
                    $added++;
                } else {
                    $skipped[] = $email;
                }
                continue;
            }

            self::create(['email' => $email]);
            $added++;
        }

        return compact('added', 'skipped', 'invalid');
    }

    /**
     * Admin - update email & status, auto-set date columns based on flag change.
     */
    public function updateAdmin(string $email, bool $flagActive): void
    {
        $data = ['email' => $email, 'flagActive' => $flagActive];

        if ($flagActive && !$this->flagActive) {
            $data['subscribedDate']   = now();
            $data['unsubscribedDate'] = null;
        } elseif (!$flagActive && $this->flagActive) {
            $data['unsubscribedDate'] = now();
        }

        $this->update($data);
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Panel
    |--------------------------------------------------------------------------
    */

    protected static array $allowedSorts = [
        'email', 'flagActive', 'subscribedDate', 'createdDate',
    ];

    /**
     * Accessor: readable status label for table badge
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->flagActive ? 'Active' : 'Inactive';
    }

    /**
     * Table config for admin-index component
     */
    public static function getTableConfig(): array
    {
        return [
            'idKey'        => 'subscriberID',
            'emptyMessage' => 'No subscribers found',
            'emptyIcon'    => 'fa-envelope',
            'colspan'      => 6,
            'columns'      => [
                [
                    'key'   => 'email',
                    'type'  => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key'      => 'statusLabel',
                    'type'     => 'badge',
                    'class'    => 'text-center',
                    'badgeMap' => [
                        'Active'   => 'bg-success',
                        'Inactive' => 'bg-secondary',
                    ],
                ],
                [
                    'key'        => 'subscribedDate',
                    'type'       => 'date',
                    'dateFormat' => 'DD MMM YYYY',
                    'class'      => 'text-center',
                    'fallback'   => '-',
                ],
            ],
            'actions' => [
                'view' => [
                    'enabled'  => true,
                    'route'    => 'admin.subscription.show',
                    'routeKey' => 'subscriberID',
                ],
                'edit' => [
                    'enabled'  => true,
                    'type'     => 'link',
                    'route'    => 'admin.subscription.edit',
                    'routeKey' => 'subscriberID',
                ],
                'delete' => [
                    'enabled'  => true,
                    'btnClass' => 'delete-subscription-btn',
                ],
            ],
        ];
    }

    /**
     * Search & filter for admin panel
     */
    public static function searchAdmin($request)
    {
        $query = self::query();

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        $flagActive = $request->input('flagActive');
        if ($flagActive !== null && $flagActive !== '') {
            $query->where('flagActive', (bool) $flagActive);
        }

        if ($request->filled('subscribedDate')) {
            $dates = explode(' - ', $request->subscribedDate);
            if (count($dates) === 2) {
                try {
                    $start = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[0]))->startOfDay();
                    $end   = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('subscribedDate', [$start, $end]);
                } catch (\Exception $e) {}
            }
        }

        $sortBy    = in_array($request->input('sort_by'), static::$allowedSorts) ? $request->input('sort_by') : 'createdDate';
        $sortOrder = $request->input('sort_order') === 'asc' ? 'asc' : 'desc';

        return $query->orderBy($sortBy, $sortOrder)->paginate(15)->appends($request->query());
    }
}
