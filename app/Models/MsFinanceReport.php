<?php

namespace App\Models;

use App\Services\GoogleDrive;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MsFinanceReport extends Model
{
    // Google Drive folder ID for finance report files
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
            'ldkID' => 'LDK',
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
            $model->createdBy = auth()->check() ? auth()->user()->name : 'SYSTEM';
            $model->createdDate = now();
            $model->editedBy = auth()->check() ? auth()->user()->name : 'SYSTEM';
            $model->editedDate = now();
            $model->flagActive = 1;
        });

        static::updating(function ($model) {
            $model->editedBy = auth()->check() ? auth()->user()->name : 'SYSTEM';
            $model->editedDate = now();
        });
    }

    /**
     * Validate request data for create/update operations
     */
    public static function validateRequest(Request $request, $ignoreId = null): array
    {
        $rules = [
            'fileName' => 'required|string|max:255',
            'ldkID' => 'required|exists:lk_ldk,ldkID',
            'pdfFile' => 'required_if:financeReportID,null|nullable|mimes:pdf|max:5120', // 5MB max
        ];

        if ($ignoreId !== null) {
            $rules['pdfFile'] = 'nullable|mimes:pdf|max:5120';
        }

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

        return $query->orderBy($sortBy, $sortOrder)
            ->paginate(15)
            ->appends($request->all());
    }

    /**
     * Get all unique LDK tags for dropdown
     */
    public static function getUniqueLdkTags()
    {
        return LkLDK::orderBy('ldkTag')->pluck('ldkTag')->unique();
    }

    /**
     * Save new finance report model with PDF file upload
     */
    public static function saveModel(Request $request): self
    {
        $fileGdriveID = null;

        // Handle PDF file upload to Google Drive
        if ($request->hasFile('pdfFile')) {
            $file = $request->file('pdfFile');
            $originalName = $file->getClientOriginalName();
            $fileName = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $uniqueFileName = time() . '_' . Str::slug($fileName) . '.' . $extension;

            $gdriveService = new GoogleDrive(self::PATH_FINANCE_REPORT_FILE_GDRIVE_ID);
            $uploadResult = $gdriveService->uploadFile($file, $uniqueFileName, self::PATH_FINANCE_REPORT_FILE_GDRIVE_ID . '/' . $uniqueFileName);
            $fileGdriveID = $uploadResult['gdriveID'];
        }

        return self::create([
            'fileName' => $request->fileName,
            'fileGdriveID' => $fileGdriveID,
            'ldkID' => $request->ldkID,
            'flagActive' => 1,
        ]);
    }

    /**
     * Get file URL from Google Drive
     */
    public function fileUrl()
    {
        if ($this->fileGdriveID) {
            $gdriveService = new GoogleDrive(self::PATH_FINANCE_REPORT_FILE_GDRIVE_ID);
            return $gdriveService->getFileDownloadUrl($this->fileGdriveID);
        }
        return null;
    }

    /**
     * Get file view URL from Google Drive
     */
    public function fileViewUrl()
    {
        if ($this->fileGdriveID) {
            $gdriveService = new GoogleDrive(self::PATH_FINANCE_REPORT_FILE_GDRIVE_ID);
            return $gdriveService->getFileUrl($this->fileGdriveID);
        }
        return null;
    }

    /**
     * Update finance report model with optional PDF file replacement
     */
    public function updateModel(Request $request): void
    {
        $data = [
            'fileName' => $request->fileName,
            'ldkID' => $request->ldkID,
        ];

        // Handle PDF file update
        if ($request->hasFile('pdfFile')) {
            // Delete old file from Google Drive if exists
            if ($this->fileGdriveID) {
                $this->deleteFileFromDrive();
            }

            $file = $request->file('pdfFile');
            $originalName = $file->getClientOriginalName();
            $fileName = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $uniqueFileName = time() . '_' . Str::slug($fileName) . '.' . $extension;

            $gdriveService = new GoogleDrive(self::PATH_FINANCE_REPORT_FILE_GDRIVE_ID);
            $uploadResult = $gdriveService->uploadFile($file, $uniqueFileName, self::PATH_FINANCE_REPORT_FILE_GDRIVE_ID . '/' . $uniqueFileName);

            $data['fileGdriveID'] = $uploadResult['gdriveID'];
        }

        $this->update($data);
    }

    /**
     * Delete finance report model and associated file
     */
    public function deleteModel(): void
    {
        try {
            $this->deleteFileFromDrive();
            $this->delete();
        } catch (\Exception $e) {
            Log::error("Error deleting finance report ID {$this->financeReportID}: " . $e->getMessage());
            throw new \Exception('Failed to delete finance report and its file');
        }
    }

    /**
     * Bulk delete multiple finance reports
     */
    public static function bulkDeleteModel(array $ids): void
    {
        try {
            $reports = self::whereIn('financeReportID', $ids)->get();

            foreach ($reports as $report) {
                $report->deleteModel();
            }
        } catch (\Exception $e) {
            Log::error("Error bulk deleting finance reports: " . $e->getMessage());
            throw new \Exception('Failed to delete selected finance reports');
        }
    }

    /**
     * Delete associated file from Google Drive
     */
    protected function deleteFileFromDrive(): void
    {
        try {
            if ($this->fileGdriveID) {
                $gdriveService = new GoogleDrive(self::PATH_FINANCE_REPORT_FILE_GDRIVE_ID);
                $gdriveService->deleteFile($this->fileGdriveID);
            }
        } catch (\Exception $e) {
            Log::error("Error deleting file for finance report ID {$this->financeReportID}: " . $e->getMessage());
            throw new \Exception('Failed to delete associated file');
        }
    }

    /**
     * Get LDK tag name
     */
    public function getLdkTagAttribute()
    {
        return $this->ldk ? $this->ldk->ldkTag : 'N/A';
    }
}
