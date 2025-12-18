<?php

namespace App\Models;

use App\Services\GoogleDrive;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MsFinanceReport extends Model
{
    // Google Drive folder ID for cover images
    public const PATH_FINANCE_REPORT_FILE_GDRIVE_ID = '1nDojsRpdH6obhzTeqiFxBcPk1Z7OOJao';

    protected $table = 'ms_finance_report';
    protected $primaryKey = 'financeReportID';
    public $timestamps = false;

    // Mass assignable attributes
    protected $fillable = [
        'fileName',
        'fileGdriveID',
        'ldkID',
        'flagActive',
        'createdBy',
        'createdDate',
        'editedBy',
        'editedDate',
    ];

    // Attribute casting
    protected $casts = [
        'flagActive' => 'boolean',
        'createdDate' => 'datetime',
        'editedDate' => 'datetime',
    ];

    /**
     * Get the table name for the model
     */
    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    /**
     * Get attribute labels for forms and displays
     */
    public static function attributeLabels(): array
    {
        return [
            'financeReportID' => 'Finance Report ID',
            'fileName' => 'File Name',
            'fileGdriveID' => 'File GDrive ID',
            'ldkID' => 'LDK ID',
            'flagActive' => 'Flag Active',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }

    /**
     * Boot method for model events
     */
    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->createdBy = auth()->check() ? auth()->user()->username : 'SYSTEM';
            $model->createdDate = now();
            $model->editedBy = auth()->check() ? auth()->user()->username : 'SYSTEM';
            $model->editedDate = now();
        });

        static::updating(function ($model) {
            $model->editedBy = auth()->check() ? auth()->user()->username : 'SYSTEM';
            $model->editedDate = now();
        });
    }

    /**
     * Validate request data for create/update operations
     */
    public static function validateRequest(Request $request, $ignoreId = null): array
    {
        $rules = [];

        return $request->validate($rules);
    }
}
