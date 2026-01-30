<?php

namespace App\Models;

use App\Services\GoogleDrive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Event extends Model
{
    use HasFactory;

    // Google Drive folder ID for event posters
    public const PATH_EVENT_GDRIVE_ID = '1iQgMUHmSTJVXG7LbmKvXjFPNz4gmyYak';

    protected $table = 'events';
    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $casts = [
        'start' => 'datetime',
        'finished' => 'datetime',
        'closeRegist' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get table configuration for admin index table component
     */
    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'No events found',
            'emptyIcon' => 'fa-calendar-alt',
            'colspan' => 7,
            'columns' => [
                [
                    'key' => 'title',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'division',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'start',
                    'type' => 'date',
                    'dateFormat' => 'dddd, DD MMMM YYYY',
                    'fallback' => 'Undefined',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'linkRegist',
                    'type' => 'link',
                    'fallback' => 'Undefined',
                    'class' => 'text-start',
                ],
            ],
            'actions' => [
                'view' => [
                    'enabled' => true,
                    'route' => 'admin.event.preview',
                    'routeKey' => 'id',
                ],
                'edit' => [
                    'enabled' => true,
                    'type' => 'link',
                    'route' => 'admin.event.edit',
                    'routeKey' => 'id',
                ],
                'delete' => [
                    'enabled' => true,
                    'btnClass' => 'delete-event-btn',
                ],
            ],
        ];
    }

    /**
     * Search and filter events for admin panel with pagination
     */
    public static function searchAdminEvents(Request $request)
    {
        $query = self::query();

        // Search by title
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Search by division/organizer
        if ($request->filled('division')) {
            $query->where('division', 'like', '%' . $request->division . '%');
        }

        // Search by linkRegist
        if ($request->filled('linkRegist')) {
            $query->where('linkRegist', 'like', '%' . $request->linkRegist . '%');
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $dates = explode(' - ', $request->start_date);
            if (count($dates) == 2) {
                try {
                    $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[0]))->startOfDay();
                    $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('start', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    // Invalid date format, skip filter
                }
            }
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        $allowedSorts = ['title', 'division', 'start', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate(15)->appends($request->query());
    }

    /**
     * Get all divisions for filter dropdown
     */
    public static function getDivisions()
    {
        return self::select('division')
            ->whereNotNull('division')
            ->distinct()
            ->orderBy('division')
            ->pluck('division');
    }

    /**
     * Validate request for store/update
     */
    public static function validateRequest(Request $request, $id = null)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'poster' => $id ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120' : 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'start' => 'nullable|date',
            'finished' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'place' => 'nullable|string|max:255',
            'linkRegist' => 'nullable|url',
            'linkLocation' => 'nullable|url',
            'linkDoc' => 'nullable|url',
            'linkPresent' => 'nullable|url',
        ]);
    }

    /**
     * Save new event
     */
    public static function saveModel(Request $request): self
    {
        $gdriveService = new GoogleDrive(self::PATH_EVENT_GDRIVE_ID);

        $fileName = time() . '_event_' . $request->file('poster')->getClientOriginalName();
        $filePath = self::PATH_EVENT_GDRIVE_ID . '/' . $fileName;

        $uploadResult = $gdriveService->uploadImage($request->file('poster'), $fileName, $filePath);

        return self::create([
            'title' => $request->title,
            'division' => $request->division,
            'broadcast' => $request->broadcast,
            'tag' => $request->tag,
            'closeRegist' => $request->closeRegist,
            'linkRegist' => $request->linkRegist,
            'start' => $request->start,
            'finished' => $request->finished,
            'location' => $request->location,
            'linkLocation' => $request->linkLocation,
            'place' => $request->place,
            'linkDoc' => $request->linkDoc,
            'linkPresent' => $request->linkPresent,
            'cntctPrsn1' => $request->cntctPrsn1,
            'cntctPrsn2' => $request->cntctPrsn2,
            'nameCntctPrsn1' => $request->nameCntctPrsn1,
            'nameCntctPrsn2' => $request->nameCntctPrsn2,
            'poster' => $uploadResult['fileName'],
            'gdrive_id' => $uploadResult['gdriveID'],
        ]);
    }

    /**
     * Update existing event
     */
    public function updateModel(Request $request): self
    {
        if ($request->hasFile('poster')) {
            $gdriveService = new GoogleDrive(self::PATH_EVENT_GDRIVE_ID);

            $fileName = time() . '_event_' . $request->file('poster')->getClientOriginalName();
            $filePath = self::PATH_EVENT_GDRIVE_ID . '/' . $fileName;

            $uploadResult = $gdriveService->uploadImage($request->file('poster'), $fileName, $filePath);

            // Delete old image
            if ($this->gdrive_id) {
                $gdriveService->deleteImage($this->gdrive_id);
            }

            $this->update([
                'poster' => $uploadResult['fileName'],
                'gdrive_id' => $uploadResult['gdriveID'],
            ]);
        }

        $this->update([
            'title' => $request->title,
            'division' => $request->division,
            'broadcast' => $request->broadcast,
            'tag' => $request->tag,
            'closeRegist' => $request->closeRegist,
            'linkRegist' => $request->linkRegist,
            'start' => $request->start,
            'finished' => $request->finished,
            'location' => $request->location,
            'linkLocation' => $request->linkLocation,
            'place' => $request->place,
            'linkDoc' => $request->linkDoc,
            'linkPresent' => $request->linkPresent,
            'cntctPrsn1' => $request->cntctPrsn1,
            'cntctPrsn2' => $request->cntctPrsn2,
            'nameCntctPrsn1' => $request->nameCntctPrsn1,
            'nameCntctPrsn2' => $request->nameCntctPrsn2,
        ]);

        return $this;
    }

    /**
     * Delete event and its poster from Google Drive
     */
    public function deleteModel(): bool
    {
        if ($this->gdrive_id) {
            $gdriveService = new GoogleDrive(self::PATH_EVENT_GDRIVE_ID);
            $gdriveService->deleteImage($this->gdrive_id);
        }

        return $this->delete();
    }

    /**
     * Bulk delete events
     */
    public static function bulkDeleteModel(array $ids): int
    {
        $events = self::whereIn('id', $ids)->get();
        $gdriveService = new GoogleDrive(self::PATH_EVENT_GDRIVE_ID);

        foreach ($events as $event) {
            if ($event->gdrive_id) {
                $gdriveService->deleteImage($event->gdrive_id);
            }
        }

        return self::whereIn('id', $ids)->delete();
    }

    /**
     * Get poster URL from Google Drive
     */
    public function getPosterUrl(): ?string
    {
        if ($this->gdrive_id) {
            return "https://drive.google.com/uc?export=view&id={$this->gdrive_id}";
        }
        return null;
    }
}
