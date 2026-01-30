<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\GoogleDrive;
use Illuminate\Http\Request;

class ITSupport extends Model
{
    use HasFactory;
    protected $guarded = [];

    public const PATH_ITSUPPORT_GDRIVE_ID = '1gE3j9fXZIicfqeFqTYuc5JFpJe-FbSBs';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Allowed sort columns
     */
    protected static array $allowedSorts = [
        'name',
        'forkat',
        'position',
        'created_at',
    ];

    /**
     * Get table configuration for admin index table component
     */
    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'No IT Support found',
            'emptyIcon' => 'fa-headset',
            'colspan' => 8,
            'columns' => [
                [
                    'key' => 'name',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'forkat',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'position',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'linkInstagram',
                    'type' => 'link',
                    'class' => 'text-center',
                    'fallback' => '-',
                ],
                [
                    'key' => 'linkLinkedin',
                    'type' => 'link',
                    'class' => 'text-center',
                    'fallback' => '-',
                ],
            ],
            'actions' => [
                'view' => [
                    'enabled' => true,
                    'route' => 'admin.about.itsupport.preview',
                    'routeKey' => 'id',
                ],
                'edit' => [
                    'enabled' => true,
                    'type' => 'link',
                    'route' => 'admin.about.itsupport.edit',
                    'routeKey' => 'id',
                ],
                'delete' => [
                    'enabled' => true,
                    'btnClass' => 'delete-itsupport-btn',
                ],
            ],
        ];
    }

    /**
     * Get unique forkat options for select2 filter
     */
    public static function getForkatOptions(): array
    {
        return self::select('forkat')
            ->distinct()
            ->orderBy('forkat')
            ->pluck('forkat', 'forkat')
            ->filter()
            ->toArray();
    }

    /**
     * Get unique position options for select2 filter
     */
    public static function getPositionOptions(): array
    {
        return self::select('position')
            ->distinct()
            ->orderBy('position')
            ->pluck('position', 'position')
            ->filter()
            ->toArray();
    }

    /**
     * Search and filter IT Supports for admin panel with pagination
     */
    public static function searchAdminITSupports(Request $request)
    {
        $query = self::query();

        // Search by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Filter by forkat
        if ($request->filled('forkat')) {
            $query->where('forkat', $request->forkat);
        }

        // Filter by position
        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        // Filter by created date range
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
     * Save new IT Support
     */
    public static function saveModel(Request $request): self
    {
        $gdriveService = new GoogleDrive(self::PATH_ITSUPPORT_GDRIVE_ID);

        $fileName = time() . '_it-supports_' . $request->file('photoProfile')->getClientOriginalName();
        $filePath = self::PATH_ITSUPPORT_GDRIVE_ID . '/' . $fileName;

        $uploadResult = $gdriveService->uploadImage($request->file('photoProfile'), $fileName, $filePath);

        return self::create([
            'name' => $request->name,
            'forkat' => $request->forkat,
            'position' => $request->position,
            'linkInstagram' => $request->linkInstagram,
            'linkLinkedin' => $request->linkLinkedin,
            'gdrive_id' => $uploadResult['gdriveID'],
            'photoProfile' => $uploadResult['fileName'],
        ]);
    }

    /**
     * Update existing IT Support
     */
    public function updateModel(Request $request): self
    {
        if ($request->hasFile('photoProfile')) {
            $gdriveService = new GoogleDrive(self::PATH_ITSUPPORT_GDRIVE_ID);

            $fileName = time() . '_it-supports_' . $request->file('photoProfile')->getClientOriginalName();
            $filePath = self::PATH_ITSUPPORT_GDRIVE_ID . '/' . $fileName;

            $uploadResult = $gdriveService->uploadImage($request->file('photoProfile'), $fileName, $filePath);

            if ($this->gdrive_id) {
                $gdriveService->deleteImage($this->gdrive_id);
            }

            $this->update([
                'photoProfile' => $uploadResult['fileName'],
                'gdrive_id' => $uploadResult['gdriveID'],
            ]);
        }

        $this->update([
            'name' => $request->name,
            'forkat' => $request->forkat,
            'position' => $request->position,
            'linkInstagram' => $request->linkInstagram,
            'linkLinkedin' => $request->linkLinkedin,
        ]);

        return $this;
    }

    /**
     * Delete IT Support and its image from Google Drive
     */
    public function deleteModel(): bool
    {
        $gdriveService = new GoogleDrive(self::PATH_ITSUPPORT_GDRIVE_ID);

        if ($this->gdrive_id) {
            $gdriveService->deleteImage($this->gdrive_id);
        }

        return $this->delete();
    }

    /**
     * Bulk delete IT Supports
     */
    public static function bulkDeleteModel(array $ids): int
    {
        $items = self::whereIn('id', $ids)->get();
        $gdriveService = new GoogleDrive(self::PATH_ITSUPPORT_GDRIVE_ID);

        foreach ($items as $item) {
            if ($item->gdrive_id) {
                $gdriveService->deleteImage($item->gdrive_id);
            }
        }

        return self::whereIn('id', $ids)->delete();
    }

    /**
     * Get photo profile URL from Google Drive
     */
    public function getPhotoProfileUrl(): ?string
    {
        if ($this->gdrive_id) {
            return "https://lh3.googleusercontent.com/d/{$this->gdrive_id}";
        }
        return null;
    }
}
