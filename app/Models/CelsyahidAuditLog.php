<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CelsyahidAuditLog extends Model
{
    protected $table = 'tr_celsyahid_audit_log';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'entity_type',
        'entity_id',
        'description',
        'ip_address',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Record an admin action. Wrapped in try/catch so audit logging
     * never breaks the underlying action.
     */
    public static function record($action, $entityType = null, $entityId = null, $description = null)
    {
        try {
            return self::create([
                'user_id'     => optional(auth()->user())->id,
                'action'      => $action,
                'entity_type' => $entityType,
                'entity_id'   => $entityId !== null ? (string) $entityId : null,
                'description' => $description,
                'ip_address'  => request()->ip(),
                'created_at'  => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('CelsyahidAuditLog::record failed: ' . $e->getMessage());
            return null;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
