<?php

namespace App\Models\forms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class TrFormAuditLog extends Model
{
    protected $table      = 'tr_form_audit_log';
    protected $primaryKey = 'formAuditLogID';
    public    $timestamps = false;

    protected $fillable = [
        'formID',
        'userID',
        'action',
        'payload',
        'ipAddress',
        'createdDate',
    ];

    protected $casts = [
        'payload'     => 'array',
        'createdDate' => 'datetime',
    ];

    // -------------------------------------------------------------------------
    // Action constants
    // -------------------------------------------------------------------------

    public const ACTION_CREATE      = 'create';
    public const ACTION_UPDATE      = 'update';
    public const ACTION_PUBLISH     = 'publish';
    public const ACTION_CLOSE       = 'close';
    public const ACTION_ARCHIVE     = 'archive';
    public const ACTION_DELETE      = 'delete';
    public const ACTION_RESTORE     = 'restore';
    public const ACTION_ADD_FIELD   = 'add_field';
    public const ACTION_REMOVE_FIELD = 'remove_field';
    public const ACTION_REORDER     = 'reorder';

    // -------------------------------------------------------------------------
    // Business Logic
    // -------------------------------------------------------------------------

    /**
     * Write a single audit log entry.
     */
    public static function record(
        ?int    $formID,
        ?int    $userID,
        string  $action,
        ?array  $payload = null,
        ?string $ipAddress = null
    ): void {
        self::create([
            'formID'      => $formID,
            'userID'      => $userID,
            'action'      => $action,
            'payload'     => $payload,
            'ipAddress'   => $ipAddress,
            'createdDate' => Carbon::now(),
        ]);
    }

    /**
     * Convenience method — record an admin action from the current request.
     */
    public static function recordAction(
        ?int   $formID,
        string $action,
        ?array $payload = null
    ): void {
        self::record(
            formID:    $formID,
            userID:    auth()->id(),
            action:    $action,
            payload:   $payload,
            ipAddress: request()->ip(),
        );
    }
}
