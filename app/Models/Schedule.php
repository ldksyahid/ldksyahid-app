<?php

namespace App\Models;

use App\Services\GoogleDrive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Schedule extends Model
{
    use HasFactory;

    // Google Drive folder ID for schedule images
    public const PATH_SCHEDULE_GDRIVE_ID = '16hEKrP0GhcA1Qrga1_s4dsNaLbIbcdIt';

    protected $table = 'schedules';
    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Allowed sort columns
     */
    protected static array $allowedSorts = [
        'title',
        'month',
        'year',
        'created_at'
    ];

    /**
     * Get table configuration for admin index table component
     */
    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'No schedules found',
            'emptyIcon' => 'fa-calendar-alt',
            'colspan' => 6,
            'columns' => [
                [
                    'key' => 'title',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'month',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'year',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
            ],
            'actions' => [
                'view' => [
                    'enabled' => true,
                    'route' => 'admin.schedule.preview',
                    'routeKey' => 'id',
                ],
                'edit' => [
                    'enabled' => true,
                    'type' => 'link',
                    'route' => 'admin.schedule.edit',
                    'routeKey' => 'id',
                ],
                'delete' => [
                    'enabled' => true,
                    'btnClass' => 'delete-schedule-btn',
                ],
            ],
        ];
    }

    /**
     * Search and filter schedules for admin panel with pagination
     */
    public static function searchAdminSchedules(Request $request)
    {
        $query = self::query();

        // Search by title
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Search by month
        if ($request->filled('month')) {
            $query->where('month', 'like', '%' . $request->month . '%');
        }

        // Search by year
        if ($request->filled('year')) {
            $query->where('year', 'like', '%' . $request->year . '%');
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
     * Save new schedule
     */
    public static function saveModel(Request $request): self
    {
        $gdriveService = new GoogleDrive(self::PATH_SCHEDULE_GDRIVE_ID);

        $fileName = time() . '_schedule_' . $request->file('picture')->getClientOriginalName();
        $filePath = self::PATH_SCHEDULE_GDRIVE_ID . '/' . $fileName;

        $uploadResult = $gdriveService->uploadImage($request->file('picture'), $fileName, $filePath);

        return self::create([
            'title' => $request->title,
            'month' => $request->month,
            'year' => $request->year,
            'picture' => $uploadResult['fileName'],
            'gdrive_id' => $uploadResult['gdriveID'],
        ]);
    }

    /**
     * Update existing schedule
     */
    public function updateModel(Request $request): self
    {
        if ($request->hasFile('picture')) {
            $gdriveService = new GoogleDrive(self::PATH_SCHEDULE_GDRIVE_ID);

            $fileName = time() . '_schedule_' . $request->file('picture')->getClientOriginalName();
            $filePath = self::PATH_SCHEDULE_GDRIVE_ID . '/' . $fileName;

            $uploadResult = $gdriveService->uploadImage($request->file('picture'), $fileName, $filePath);

            // Delete old image
            if ($this->gdrive_id) {
                $gdriveService->deleteImage($this->gdrive_id);
            }

            $this->update([
                'picture' => $uploadResult['fileName'],
                'gdrive_id' => $uploadResult['gdriveID'],
            ]);
        }

        $this->update([
            'title' => $request->title,
            'month' => $request->month,
            'year' => $request->year,
        ]);

        return $this;
    }

    /**
     * Delete schedule and its image from Google Drive
     */
    public function deleteModel(): bool
    {
        if ($this->gdrive_id) {
            $gdriveService = new GoogleDrive(self::PATH_SCHEDULE_GDRIVE_ID);
            $gdriveService->deleteImage($this->gdrive_id);
        }

        return $this->delete();
    }

    /**
     * Bulk delete schedules
     */
    public static function bulkDeleteModel(array $ids): int
    {
        $schedules = self::whereIn('id', $ids)->get();
        $gdriveService = new GoogleDrive(self::PATH_SCHEDULE_GDRIVE_ID);

        foreach ($schedules as $schedule) {
            if ($schedule->gdrive_id) {
                $gdriveService->deleteImage($schedule->gdrive_id);
            }
        }

        return self::whereIn('id', $ids)->delete();
    }

    /**
     * Get picture URL from Google Drive
     */
    public function getPictureUrl(): ?string
    {
        if ($this->gdrive_id) {
            return "https://lh3.googleusercontent.com/d/{$this->gdrive_id}";
        }
        return null;
    }
}
