<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class MsFinanceReport extends Model
{
    // Google Drive folder ID for file report
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
     * Relationship to LkLDK model
     */
    public function ldk()
    {
        return $this->belongsTo(LkLDK::class, 'ldkID', 'ldkID');
    }

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

    /**
     * Search finance reports for admin panel with filters
     */
    public static function searchAdminFinanceReport(Request $request)
    {
        $sortBy = $request->input('sort_by', 'createdDate');
        $sortOrder = $request->input('sort_order', 'desc');

        $allowedSorts = [
            'fileName',
            'createdDate',
        ];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'createdDate';
        }

        $query = self::with(['ldk']);

        // Filter by file name
        if ($request->filled('file_name')) {
            $query->where('fileName', 'like', "%{$request->file_name}%");
        }

        // Filter by LDK Tag
        if ($request->filled('ldk_tag')) {
            $query->whereHas('ldk', function($q) use ($request) {
                $q->where('ldkTag', $request->ldk_tag);
            });
        }

        // Date range filter for createdDate
        if ($request->filled('created_date')) {
            $dates = explode(' - ', $request->created_date);

            if (count($dates) == 2) {
                try {
                    $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[0]))->startOfDay();
                    $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[1]))->endOfDay();

                    $query->whereBetween('createdDate', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    $query->whereDate('createdDate', $request->created_date);
                }
            } else {
                $query->whereDate('createdDate', $request->created_date);
            }
        }

        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate(15)->appends($request->all());
    }

    /**
     * Get all unique LDK tags for dropdown
     */
    public static function getUniqueLdkTags()
    {
        return LkLDK::orderBy('ldkTag')->pluck('ldkTag')->unique();
    }
}
