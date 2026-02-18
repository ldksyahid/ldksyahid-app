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
            'email.unique'   => 'Email ini sudah terdaftar di newsletter kami!',
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
                'message' => 'Terima kasih! Email Anda berhasil didaftarkan untuk berlangganan kami. 🎉',
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
}
