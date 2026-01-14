<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\GoogleDrive;
use Illuminate\Http\Request;

class Gallery extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Google Drive folder ID for gallery images
    public const PATH_GALLERY_GDRIVE_ID = '1d_ZOMfeFVkATb6gWYVFtttTNE-k0nCsv';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Allowed sort columns
     */
    protected static array $allowedSorts = [
        'eventName',
        'eventTheme',
        'created_at'
    ];

    /**
     * Get table configuration for admin index table component
     */
    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'No galleries found',
            'emptyIcon' => 'fa-images',
            'colspan' => 6,
            'columns' => [
                [
                    'key' => 'eventName',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'eventTheme',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'linkEmbedYoutube',
                    'type' => 'link',
                    'class' => 'text-center',
                    'fallback' => '-',
                ],
            ],
            'actions' => [
                'view' => [
                    'enabled' => true,
                    'route' => 'admin.gallery.preview',
                    'routeKey' => 'id',
                ],
                'edit' => [
                    'enabled' => true,
                    'type' => 'link',
                    'route' => 'admin.about.gallery.edit',
                    'routeKey' => 'id',
                ],
                'delete' => [
                    'enabled' => true,
                    'btnClass' => 'delete-gallery-btn',
                ],
            ],
        ];
    }

    /**
     * Get unique event names for select2 filter
     */
    public static function getEventNameOptions(): array
    {
        return self::select('eventName')
            ->distinct()
            ->orderBy('eventName')
            ->pluck('eventName', 'eventName')
            ->filter()
            ->toArray();
    }

    /**
     * Get unique event themes for select2 filter
     */
    public static function getEventThemeOptions(): array
    {
        return self::select('eventTheme')
            ->distinct()
            ->orderBy('eventTheme')
            ->pluck('eventTheme', 'eventTheme')
            ->filter()
            ->toArray();
    }

    /**
     * Search and filter galleries for admin panel with pagination
     */
    public static function searchAdminGalleries(Request $request)
    {
        $query = self::query();

        // Search by eventName
        if ($request->filled('eventName')) {
            $query->where('eventName', $request->eventName);
        }

        // Search by eventTheme
        if ($request->filled('eventTheme')) {
            $query->where('eventTheme', $request->eventTheme);
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
     * Save new gallery
     */
    public static function saveModel(Request $request): self
    {
        $gdriveService = new GoogleDrive(self::PATH_GALLERY_GDRIVE_ID);

        // Upload group photo
        $fileNameGroupPhoto = time() . '_groupPhoto_' . $request->file('groupPhoto')->getClientOriginalName();
        $filePathGroupPhoto = self::PATH_GALLERY_GDRIVE_ID . '/' . $fileNameGroupPhoto;
        $uploadResultGroupPhoto = $gdriveService->uploadImage($request->file('groupPhoto'), $fileNameGroupPhoto, $filePathGroupPhoto);

        // Upload additional photos
        $photos = [];
        for ($i = 1; $i <= 12; $i++) {
            $photoKey = 'photo' . $i;
            if ($request->hasFile($photoKey)) {
                $fileName = time() . '_' . $photoKey . '_' . $request->file($photoKey)->getClientOriginalName();
                $filePath = self::PATH_GALLERY_GDRIVE_ID . '/' . $fileName;
                $uploadResult = $gdriveService->uploadImage($request->file($photoKey), $fileName, $filePath);
                $photos[$photoKey] = [
                    'fileName' => $uploadResult['fileName'] ?? null,
                    'gdriveID' => $uploadResult['gdriveID'] ?? null
                ];
            } else {
                $photos[$photoKey] = ['fileName' => null, 'gdriveID' => null];
            }
        }

        $galleryData = [
            'eventName' => $request->eventName,
            'eventTheme' => $request->eventTheme,
            'eventDescription' => $request->eventDescription,
            'linkEmbedYoutube' => $request->linkEmbedYoutube,
            'linkDoc' => $request->linkDoc,
            'groupPhoto' => $uploadResultGroupPhoto['fileName'] ?? null,
            'gdrive_id' => $uploadResultGroupPhoto['gdriveID'] ?? null,
        ];

        for ($i = 1; $i <= 12; $i++) {
            $photoKey = 'photo' . $i;
            $gdriveKey = 'gdrive_id_' . $i;
            $galleryData[$photoKey] = $photos[$photoKey]['fileName'];
            $galleryData[$gdriveKey] = $photos[$photoKey]['gdriveID'];
        }

        return self::create($galleryData);
    }

    /**
     * Update existing gallery
     */
    public function updateModel(Request $request): self
    {
        $gdriveService = new GoogleDrive(self::PATH_GALLERY_GDRIVE_ID);

        // Update group photo if provided
        if ($request->hasFile('groupPhoto')) {
            $fileNameGroupPhoto = time() . '_groupPhoto_' . $request->file('groupPhoto')->getClientOriginalName();
            $filePathGroupPhoto = self::PATH_GALLERY_GDRIVE_ID . '/' . $fileNameGroupPhoto;
            $uploadResultGroupPhoto = $gdriveService->uploadImage($request->file('groupPhoto'), $fileNameGroupPhoto, $filePathGroupPhoto);

            if (!empty($uploadResultGroupPhoto)) {
                if ($this->gdrive_id) {
                    $gdriveService->deleteImage($this->gdrive_id);
                }
                $this->update([
                    'groupPhoto' => $uploadResultGroupPhoto['fileName'],
                    'gdrive_id' => $uploadResultGroupPhoto['gdriveID'],
                ]);
            }
        }

        // Update additional photos
        for ($i = 1; $i <= 12; $i++) {
            $photoKey = 'photo' . $i;
            $gdriveKey = 'gdrive_id_' . $i;

            if ($request->hasFile($photoKey)) {
                $fileNamePhoto = time() . '_' . $photoKey . '_' . $request->file($photoKey)->getClientOriginalName();
                $filePathPhoto = self::PATH_GALLERY_GDRIVE_ID . '/' . $fileNamePhoto;
                $uploadResultPhoto = $gdriveService->uploadImage($request->file($photoKey), $fileNamePhoto, $filePathPhoto);

                if (!empty($uploadResultPhoto)) {
                    if ($this->$gdriveKey) {
                        $gdriveService->deleteImage($this->$gdriveKey);
                    }
                    $this->update([
                        $photoKey => $uploadResultPhoto['fileName'],
                        $gdriveKey => $uploadResultPhoto['gdriveID'],
                    ]);
                }
            }
        }

        $this->update([
            'eventName' => $request->eventName,
            'eventTheme' => $request->eventTheme,
            'eventDescription' => $request->eventDescription,
            'linkEmbedYoutube' => $request->linkEmbedYoutube,
            'linkDoc' => $request->linkDoc,
        ]);

        return $this;
    }

    /**
     * Delete gallery and all its images from Google Drive
     */
    public function deleteModel(): bool
    {
        $gdriveService = new GoogleDrive(self::PATH_GALLERY_GDRIVE_ID);

        // Delete group photo
        if ($this->gdrive_id) {
            $gdriveService->deleteImage($this->gdrive_id);
        }

        // Delete additional photos
        for ($i = 1; $i <= 12; $i++) {
            $gdriveKey = 'gdrive_id_' . $i;
            if ($this->$gdriveKey) {
                $gdriveService->deleteImage($this->$gdriveKey);
            }
        }

        return $this->delete();
    }

    /**
     * Bulk delete galleries
     */
    public static function bulkDeleteModel(array $ids): int
    {
        $galleries = self::whereIn('id', $ids)->get();
        $gdriveService = new GoogleDrive(self::PATH_GALLERY_GDRIVE_ID);

        foreach ($galleries as $gallery) {
            // Delete group photo
            if ($gallery->gdrive_id) {
                $gdriveService->deleteImage($gallery->gdrive_id);
            }
            // Delete additional photos
            for ($i = 1; $i <= 12; $i++) {
                $gdriveKey = 'gdrive_id_' . $i;
                if ($gallery->$gdriveKey) {
                    $gdriveService->deleteImage($gallery->$gdriveKey);
                }
            }
        }

        return self::whereIn('id', $ids)->delete();
    }

    /**
     * Get group photo URL from Google Drive
     */
    public function getGroupPhotoUrl(): ?string
    {
        if ($this->gdrive_id) {
            return "https://lh3.googleusercontent.com/d/{$this->gdrive_id}";
        }
        return null;
    }

    /**
     * Get photo URL by index from Google Drive
     */
    public function getPhotoUrl(int $index): ?string
    {
        $gdriveKey = 'gdrive_id_' . $index;
        if ($this->$gdriveKey) {
            return "https://lh3.googleusercontent.com/d/{$this->$gdriveKey}";
        }
        return null;
    }
}
