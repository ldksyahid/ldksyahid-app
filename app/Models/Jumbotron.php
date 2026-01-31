<?php

namespace App\Models;

use App\Services\GoogleDrive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Jumbotron extends Model
{
    use HasFactory;

    // Google Drive folder ID for jumbotron images
    public const PATH_JUMBOTRON_GDRIVE_ID = '1RflrHwMXU-QZfh-unZyfL5UGD8fvEWz8';

    protected $table = 'jumbotrons';
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
        'btnname',
        'created_at'
    ];

    /**
     * Get table configuration for admin index table component
     */
    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'No jumbotrons found',
            'emptyIcon' => 'fa-images',
            'colspan' => 7,
            'columns' => [
                [
                    'key' => 'title',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'btnname',
                    'type' => 'text',
                    'class' => 'text-center',
                    'fallback' => 'None',
                ],
                [
                    'key' => 'btnlink',
                    'type' => 'link',
                    'class' => 'text-start',
                    'fallback' => 'None',
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
                    'route' => 'admin.jumbotron.preview',
                    'routeKey' => 'id',
                ],
                'edit' => [
                    'enabled' => true,
                    'type' => 'link',
                    'route' => 'admin.jumbotron.edit',
                    'routeKey' => 'id',
                ],
                'delete' => [
                    'enabled' => true,
                    'btnClass' => 'delete-jumbotron-btn',
                ],
            ],
        ];
    }

    /**
     * Search and filter jumbotrons for admin panel with pagination
     */
    public static function searchAdminJumbotrons(Request $request)
    {
        $query = self::query();

        // Search by title
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Search by button name
        if ($request->filled('btnname')) {
            $query->where('btnname', 'like', '%' . $request->btnname . '%');
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
     * Save new jumbotron
     */
    public static function saveModel(Request $request): self
    {
        $gdriveService = new GoogleDrive(self::PATH_JUMBOTRON_GDRIVE_ID);

        $fileName = time() . '_jumbotron_' . $request->file('picture')->getClientOriginalName();
        $filePath = self::PATH_JUMBOTRON_GDRIVE_ID . '/' . $fileName;

        $uploadResult = $gdriveService->uploadImage($request->file('picture'), $fileName, $filePath);

        return self::create([
            'title' => $request->title,
            'subtitle' => 'none',
            'sentence' => 'none',
            'btnname' => $request->buttonname,
            'btnlink' => $request->buttonlink,
            'picture' => $uploadResult['fileName'],
            'gdrive_id' => $uploadResult['gdriveID'],
            'textalign' => 'start',
        ]);
    }

    /**
     * Update existing jumbotron
     */
    public function updateModel(Request $request): self
    {
        if ($request->hasFile('picture')) {
            $gdriveService = new GoogleDrive(self::PATH_JUMBOTRON_GDRIVE_ID);

            $fileName = time() . '_jumbotron_' . $request->file('picture')->getClientOriginalName();
            $filePath = self::PATH_JUMBOTRON_GDRIVE_ID . '/' . $fileName;

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
            'subtitle' => 'none',
            'sentence' => 'none',
            'btnname' => $request->buttonname,
            'btnlink' => $request->buttonlink,
            'textalign' => 'start',
        ]);

        return $this;
    }

    /**
     * Delete jumbotron and its image from Google Drive
     */
    public function deleteModel(): bool
    {
        if ($this->gdrive_id) {
            $gdriveService = new GoogleDrive(self::PATH_JUMBOTRON_GDRIVE_ID);
            $gdriveService->deleteImage($this->gdrive_id);
        }

        return $this->delete();
    }

    /**
     * Bulk delete jumbotrons
     */
    public static function bulkDeleteModel(array $ids): int
    {
        $jumbotrons = self::whereIn('id', $ids)->get();
        $gdriveService = new GoogleDrive(self::PATH_JUMBOTRON_GDRIVE_ID);

        foreach ($jumbotrons as $jumbotron) {
            if ($jumbotron->gdrive_id) {
                $gdriveService->deleteImage($jumbotron->gdrive_id);
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
