<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Withdrawal extends Model
{
    protected $keyType    = 'string';
    public    $incrementing = false;

    protected $fillable = [
        'id', 'campaign_id', 'created_by', 'reff_id',
        'amount', 'fee', 'bank_code', 'account_number',
        'account_holder', 'recipient_city_code', 'remark',
        'status', 'bisabiller_status_id', 'receipt_url',
        'inquiry_response', 'disbursement_response',
        'executed_at', 'completed_at',
    ];

    protected $casts = [
        'inquiry_response'      => 'array',
        'disbursement_response' => 'array',
        'executed_at'           => 'datetime',
        'completed_at'          => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public static function generateReffId(string $campaignId): string
    {
        return 'WD-' . strtoupper(substr(str_replace('-', '', $campaignId), 0, 8))
            . '-' . now()->format('YmdHis')
            . '-' . strtoupper(Str::random(4));
    }

    public static function totalWithdrawnForCampaign(string $campaignId): int
    {
        return (int) static::where('campaign_id', $campaignId)
            ->where('status', 'COMPLETED')
            ->sum('amount');
    }

    public function getAmountNetAttribute(): int
    {
        return max(0, $this->amount - $this->fee);
    }

    public static function statusBadgeClass(string $status): string
    {
        return match($status) {
            'COMPLETED' => 'bg-success',
            'PENDING'   => 'bg-warning text-dark',
            'FAILED'    => 'bg-danger',
            default     => 'bg-secondary',
        };
    }
}
