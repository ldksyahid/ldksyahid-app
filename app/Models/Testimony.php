<?php

namespace App\Models;

use App\Services\GoogleDrive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Testimony extends Model
{
    use HasFactory;

    // Google Drive folder ID for testimony images
    public const PATH_TESTIMONY_GDRIVE_ID = '1w2pq-EYLmaeJ7irJ-KQaXZS0iJvn1pNY';

    protected $table = 'testimonies';
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
        'name',
        'profession',
        'created_at'
    ];

    /**
     * Get table configuration for admin index table component
     */
    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'No testimonies found',
            'emptyIcon' => 'fa-comments',
            'colspan' => 6,
            'columns' => [
                [
                    'key' => 'name',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'profession',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'created_at',
                    'type' => 'datetime',
                    'class' => 'text-center',
                    'dateFormat' => 'DD MMMM YYYY',
                    'timeFormat' => 'H:i T',
                ],
            ],
            'actions' => [
                'view' => [
                    'enabled' => true,
                    'route' => 'admin.testimony.preview',
                    'routeKey' => 'id',
                ],
                'edit' => [
                    'enabled' => true,
                    'type' => 'link',
                    'route' => 'admin.testimony.edit',
                    'routeKey' => 'id',
                ],
                'delete' => [
                    'enabled' => true,
                    'btnClass' => 'delete-testimony-btn',
                ],
            ],
        ];
    }

    /**
     * Search and filter testimonies for admin panel with pagination
     */
    public static function searchAdminTestimonies(Request $request)
    {
        $query = self::query();

        // Search by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Search by profession
        if ($request->filled('profession')) {
            $query->where('profession', 'like', '%' . $request->profession . '%');
        }

        // Filter by date range
        if ($request->filled('created_at')) {
            $dates = explode(' - ', $request->created_at);
            if (count($dates) == 2) {
                try {
                    $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[0]))->startOfDay();
                    $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    // Invalid date format, skip filter
                }
            }
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
     * Save new testimony
     */
    public static function saveModel(Request $request): self
    {
        $gdriveService = new GoogleDrive(self::PATH_TESTIMONY_GDRIVE_ID);

        $fileName = time() . '_testimony_' . $request->file('picture')->getClientOriginalName();
        $filePath = self::PATH_TESTIMONY_GDRIVE_ID . '/' . $fileName;

        $uploadResult = $gdriveService->uploadImage($request->file('picture'), $fileName, $filePath);

        return self::create([
            'name' => $request->name,
            'profession' => $request->profession,
            'testimony' => $request->testimony,
            'picture' => $uploadResult['fileName'],
            'gdrive_id' => $uploadResult['gdriveID'],
        ]);
    }

    /**
     * Update existing testimony
     */
    public function updateModel(Request $request): self
    {
        if ($request->hasFile('picture')) {
            $gdriveService = new GoogleDrive(self::PATH_TESTIMONY_GDRIVE_ID);

            $fileName = time() . '_testimony_' . $request->file('picture')->getClientOriginalName();
            $filePath = self::PATH_TESTIMONY_GDRIVE_ID . '/' . $fileName;

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
            'name' => $request->name,
            'profession' => $request->profession,
            'testimony' => $request->testimony,
        ]);

        return $this;
    }

    /**
     * Delete testimony and its image from Google Drive
     */
    public function deleteModel(): bool
    {
        if ($this->gdrive_id) {
            $gdriveService = new GoogleDrive(self::PATH_TESTIMONY_GDRIVE_ID);
            $gdriveService->deleteImage($this->gdrive_id);
        }

        return $this->delete();
    }

    /**
     * Bulk delete testimonies
     */
    public static function bulkDeleteModel(array $ids): int
    {
        $testimonies = self::whereIn('id', $ids)->get();
        $gdriveService = new GoogleDrive(self::PATH_TESTIMONY_GDRIVE_ID);

        foreach ($testimonies as $testimony) {
            if ($testimony->gdrive_id) {
                $gdriveService->deleteImage($testimony->gdrive_id);
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

    /**
     * Legacy method for API
     */
    public static function getAPITestimony()
    {
        $return = DB::table('testimonies');
        return $return;
    }
}
