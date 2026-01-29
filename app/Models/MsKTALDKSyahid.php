<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\LkFaculty;
use App\Models\LkGeneration;
use App\Models\LkMajor;
use App\Services\GoogleDrive;

class MsKTALDKSyahid extends Model
{
    public const PATH_KTA_GDRIVE_ID = '1gTa-VH6WTPFNsHxjCO0UbZVqnTpWr6t4';

    protected $table = 'ms_ktaldksyahid';

    protected $fillable = [
        'fullName', 'gender', 'nim', 'facultyID', 'majorID', 'generationID',
        'memberNumber', 'slogan', 'background', 'email', 'linkedIn', 'instagram',
        'photo', 'linkProfile', 'gdrive_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static array $allowedSorts = [
        'fullName', 'nim', 'memberNumber', 'created_at',
    ];

    // ============ RELATIONS ============

    public function getFaculty()
    {
        return $this->belongsTo(LkFaculty::class, 'facultyID', 'id');
    }

    public function getMajor()
    {
        return $this->belongsTo(LkMajor::class, 'majorID', 'id');
    }

    public function getGeneration()
    {
        return $this->belongsTo(LkGeneration::class, 'generationID', 'id');
    }

    // ============ TABLE CONFIG ============

    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'No KTA LDK Syahid found',
            'emptyIcon' => 'fa-id-card',
            'colspan' => 8,
            'columns' => [
                [
                    'key' => 'fullName',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'getGeneration.generationName',
                    'type' => 'relation',
                    'relationKey' => 'getGeneration.generationName',
                    'class' => 'text-center',
                    'fallback' => '-',
                ],
                [
                    'key' => 'memberNumber',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'linkProfile',
                    'type' => 'copy-button',
                    'class' => 'text-start',
                    'copyWithBaseUrl' => true,
                    'showAsLink' => true,
                    'linkPrefix' => '/kta/',
                    'fallback' => '-',
                ],
            ],
            'actions' => [
                'view' => [
                    'enabled' => true,
                    'route' => 'admin.ktaldksyahid.preview',
                    'routeKey' => 'id',
                ],
                'edit' => [
                    'enabled' => true,
                    'type' => 'link',
                    'route' => 'admin.ktaldksyahid.edit',
                    'routeKey' => 'id',
                ],
                'delete' => [
                    'enabled' => true,
                    'btnClass' => 'delete-kta-btn',
                ],
            ],
        ];
    }

    // ============ FILTER OPTIONS ============

    public static function getGenerationOptions(): array
    {
        return LkGeneration::orderBy('generationName')
            ->pluck('generationName', 'id')
            ->toArray();
    }

    public static function getFacultyOptions(): array
    {
        return LkFaculty::orderBy('facultyName')
            ->pluck('facultyName', 'id')
            ->toArray();
    }

    // ============ SEARCH ============

    public static function searchAdminKTA(Request $request)
    {
        $query = self::with('getFaculty', 'getMajor', 'getGeneration');

        if ($request->filled('fullName')) {
            $query->where('fullName', 'like', '%' . $request->fullName . '%');
        }

        if ($request->filled('generationID')) {
            $query->where('generationID', $request->generationID);
        }

        if ($request->filled('facultyID')) {
            $query->where('facultyID', $request->facultyID);
        }

        if ($request->filled('linkProfile')) {
            $query->where('linkProfile', 'like', '%' . $request->linkProfile . '%');
        }

        if ($request->filled('created_at_start') && $request->filled('created_at_end')) {
            $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->created_at_start)->startOfDay();
            $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->created_at_end)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        if (!in_array($sortBy, static::$allowedSorts)) {
            $sortBy = 'created_at';
        }

        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate(15)->appends($request->query());
    }

    // ============ CRUD ============

    public static function saveModel(Request $request): self
    {
        $uploadResult = [];
        if ($request->hasFile('photo')) {
            $gdriveService = new GoogleDrive(self::PATH_KTA_GDRIVE_ID);
            $fileName = time() . '_kta-ldksyahid_' . $request->file('photo')->getClientOriginalName();
            $filePath = self::PATH_KTA_GDRIVE_ID . '/' . $fileName;
            $uploadResult = $gdriveService->uploadImage($request->file('photo'), $fileName, $filePath);
        }

        return self::create([
            'fullName' => $request->fullName,
            'gender' => $request->gender,
            'nim' => $request->nim,
            'facultyID' => $request->faculty,
            'majorID' => $request->major,
            'generationID' => $request->generation,
            'memberNumber' => $request->memberNumber,
            'slogan' => $request->slogan,
            'background' => $request->background,
            'email' => $request->email,
            'linkedIn' => $request->linkedIn,
            'instagram' => $request->instagram,
            'photo' => !empty($uploadResult) ? $uploadResult['fileName'] : null,
            'gdrive_id' => !empty($uploadResult) ? $uploadResult['gdriveID'] : null,
            'linkProfile' => $request->linkProfile,
        ]);
    }

    public function updateModel(Request $request): self
    {
        if ($request->hasFile('photo')) {
            $gdriveService = new GoogleDrive(self::PATH_KTA_GDRIVE_ID);
            $fileName = time() . '_kta-ldksyahid_' . $request->file('photo')->getClientOriginalName();
            $filePath = self::PATH_KTA_GDRIVE_ID . '/' . $fileName;
            $uploadResult = $gdriveService->uploadImage($request->file('photo'), $fileName, $filePath);

            if ($this->gdrive_id) {
                $gdriveService->deleteImage($this->gdrive_id);
            }

            $this->update([
                'photo' => $uploadResult['fileName'],
                'gdrive_id' => $uploadResult['gdriveID'],
            ]);
        }

        $this->update([
            'fullName' => $request->fullName,
            'gender' => $request->gender,
            'nim' => $request->nim,
            'facultyID' => $request->faculty,
            'majorID' => $request->major,
            'generationID' => $request->generation,
            'memberNumber' => $request->memberNumber,
            'slogan' => $request->slogan,
            'background' => $request->background,
            'email' => $request->email,
            'linkedIn' => $request->linkedIn,
            'instagram' => $request->instagram,
            'linkProfile' => $request->linkProfile,
        ]);

        return $this;
    }

    public function deleteModel(): bool
    {
        $gdriveService = new GoogleDrive(self::PATH_KTA_GDRIVE_ID);
        if ($this->gdrive_id) {
            $gdriveService->deleteImage($this->gdrive_id);
        }
        return $this->delete();
    }

    public static function bulkDeleteModel(array $ids): int
    {
        $items = self::whereIn('id', $ids)->get();
        $gdriveService = new GoogleDrive(self::PATH_KTA_GDRIVE_ID);

        foreach ($items as $item) {
            if ($item->gdrive_id) {
                $gdriveService->deleteImage($item->gdrive_id);
            }
        }

        return self::whereIn('id', $ids)->delete();
    }

    public function getPhotoUrl(): ?string
    {
        if ($this->gdrive_id) {
            return "https://lh3.googleusercontent.com/d/{$this->gdrive_id}";
        }
        return null;
    }
}
