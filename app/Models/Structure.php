<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\GoogleDrive;

class Structure extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static $pathStructureGDrive = '1q4xH2GI8i7nd4LJoW97zP4CNWYa8RjZr';

    /**
     * Allowed sort columns
     */
    protected static array $allowedSorts = [
        'batch',
        'period',
        'structureName',
        'created_at'
    ];

    /**
     * Get table configuration for admin index table component
     */
    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'No structures found',
            'emptyIcon' => 'fa-sitemap',
            'colspan' => 7,
            'columns' => [
                [
                    'key' => 'batch',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'period',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'structureName',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'created_at',
                    'type' => 'date',
                    'format' => 'DD MMM YYYY',
                    'class' => 'text-center',
                ],
            ],
            'actions' => [
                'view' => [
                    'enabled' => true,
                    'route' => 'admin.about.structure.preview',
                    'routeKey' => 'id',
                ],
                'edit' => [
                    'enabled' => true,
                    'type' => 'link',
                    'route' => 'admin.about.structure.edit',
                    'routeKey' => 'id',
                ],
                'delete' => [
                    'enabled' => true,
                    'btnClass' => 'delete-structure-btn',
                ],
            ],
        ];
    }

    /**
     * Search and filter structures for admin panel with pagination
     */
    public static function searchAdminStructures($request)
    {
        $query = self::query();

        // Search by batch
        if ($request->filled('batch')) {
            $query->where('batch', 'like', '%' . $request->batch . '%');
        }

        // Search by period
        if ($request->filled('period')) {
            $query->where('period', 'like', '%' . $request->period . '%');
        }

        // Search by structure name
        if ($request->filled('structureName')) {
            $query->where('structureName', 'like', '%' . $request->structureName . '%');
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
     * Save new structure
     */
    public static function saveModel($request)
    {
        $gdriveService = new GoogleDrive(self::$pathStructureGDrive);

        // Upload logo
        $fileNameLogo = time() . '_structure-logo_' . $request->file('structureLogo')->getClientOriginalName();
        $filePathLogo = self::$pathStructureGDrive . '/' . $fileNameLogo;
        $uploadResultLogo = $gdriveService->uploadImage($request->file('structureLogo'), $fileNameLogo, $filePathLogo);

        // Upload structure image
        $fileNameImage = time() . '_structure-image_' . $request->file('structureImage')->getClientOriginalName();
        $filePathImage = self::$pathStructureGDrive . '/' . $fileNameImage;
        $uploadResultImage = $gdriveService->uploadImage($request->file('structureImage'), $fileNameImage, $filePathImage);

        return self::create([
            'batch' => $request->batch,
            'period' => $request->period,
            'structureName' => $request->structureName,
            'structureDescription' => $request->structureDescription,
            'structureLogo' => $uploadResultLogo['fileName'],
            'gdrive_id' => $uploadResultLogo['gdriveID'],
            'structureImage' => $uploadResultImage['fileName'],
            'gdrive_id_2' => $uploadResultImage['gdriveID'],
        ]);
    }

    /**
     * Update existing structure
     */
    public function updateModel($request)
    {
        if ($request->hasFile('structureLogo')) {
            $gdriveService = new GoogleDrive(self::$pathStructureGDrive);

            $fileNameLogo = time() . '_structure-logo_' . $request->file('structureLogo')->getClientOriginalName();
            $filePathLogo = self::$pathStructureGDrive . '/' . $fileNameLogo;
            $uploadResultLogo = $gdriveService->uploadImage($request->file('structureLogo'), $fileNameLogo, $filePathLogo);

            // Delete old logo
            if ($this->gdrive_id) {
                $gdriveService->deleteImage($this->gdrive_id);
            }

            $this->update([
                'structureLogo' => $uploadResultLogo['fileName'],
                'gdrive_id' => $uploadResultLogo['gdriveID'],
            ]);
        }

        if ($request->hasFile('structureImage')) {
            $gdriveService = new GoogleDrive(self::$pathStructureGDrive);

            $fileNameImage = time() . '_structure-image_' . $request->file('structureImage')->getClientOriginalName();
            $filePathImage = self::$pathStructureGDrive . '/' . $fileNameImage;
            $uploadResultImage = $gdriveService->uploadImage($request->file('structureImage'), $fileNameImage, $filePathImage);

            // Delete old structure image
            if ($this->gdrive_id_2) {
                $gdriveService->deleteImage($this->gdrive_id_2);
            }

            $this->update([
                'structureImage' => $uploadResultImage['fileName'],
                'gdrive_id_2' => $uploadResultImage['gdriveID'],
            ]);
        }

        return $this->update([
            'batch' => $request->batch,
            'period' => $request->period,
            'structureName' => $request->structureName,
            'structureDescription' => $request->structureDescription,
        ]);
    }

    /**
     * Delete structure and its images
     */
    public function deleteModel()
    {
        if ($this->gdrive_id || $this->gdrive_id_2) {
            $gdriveService = new GoogleDrive(self::$pathStructureGDrive);

            if ($this->gdrive_id) {
                $gdriveService->deleteImage($this->gdrive_id);
            }

            if ($this->gdrive_id_2) {
                $gdriveService->deleteImage($this->gdrive_id_2);
            }
        }

        return $this->delete();
    }

    /**
     * Bulk delete structures
     */
    public static function bulkDeleteModel(array $ids): int
    {
        $structures = self::whereIn('id', $ids)->get();
        $gdriveService = new GoogleDrive(self::$pathStructureGDrive);

        foreach ($structures as $structure) {
            if ($structure->gdrive_id) {
                $gdriveService->deleteImage($structure->gdrive_id);
            }
            if ($structure->gdrive_id_2) {
                $gdriveService->deleteImage($structure->gdrive_id_2);
            }
        }

        return self::whereIn('id', $ids)->delete();
    }

    /**
     * Get logo URL from Google Drive
     */
    public function getLogoUrl()
    {
        if ($this->gdrive_id) {
            return 'https://lh3.googleusercontent.com/d/' . $this->gdrive_id;
        }
        return 'https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm';
    }

    /**
     * Get structure image URL from Google Drive
     */
    public function getStructureImageUrl()
    {
        if ($this->gdrive_id_2) {
            return 'https://lh3.googleusercontent.com/d/' . $this->gdrive_id_2;
        }
        return 'https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm';
    }
}
