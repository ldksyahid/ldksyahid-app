<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SuratLog extends Model
{
    protected $fillable = [
        'user_id',
        'jenis_surat',
        'label',
        'nomor_surat',
        'kode_verifikasi',
        'data',
        'filename',
        'status',
        'catatan_admin',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'data'        => 'array',
        'approved_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (SuratLog $log) {
            if (empty($log->kode_verifikasi)) {
                $log->kode_verifikasi = (string) Str::uuid();
            }
        });
    }

    /* ── Relationships ── */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /* ── Helpers ── */
    public function isPending(): bool   { return $this->status === 'pending'; }
    public function isApproved(): bool  { return $this->status === 'approved'; }
    public function isRejected(): bool  { return $this->status === 'rejected'; }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default    => 'Menunggu',
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'approved' => 'success',
            'rejected' => 'danger',
            default    => 'warning',
        };
    }
}