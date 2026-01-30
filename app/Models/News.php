<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\GoogleDrive;

class News extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static $pathNewsGDrive = '1GyqmtdKal2IxSxAryjfO3CZKfYk6NUB8';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function newscomments()
    {
        return $this->hasMany('App\Models\NewsComment', 'news_id');
    }

    /**
     * Allowed sort columns
     */
    protected static array $allowedSorts = [
        'title',
        'datepublish',
        'publisher',
        'reporter',
        'editor',
        'created_at'
    ];

    /**
     * Get table configuration for admin index table component
     */
    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'No news found',
            'emptyIcon' => 'fa-newspaper',
            'colspan' => 8,
            'columns' => [
                [
                    'key' => 'title',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'datepublish',
                    'type' => 'date',
                    'format' => 'DD MMM YYYY',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'publisher',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'reporter',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'editor',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
            ],
            'actions' => [
                'view' => [
                    'enabled' => true,
                    'route' => 'admin.news.preview',
                    'routeKey' => 'id',
                ],
                'edit' => [
                    'enabled' => true,
                    'type' => 'link',
                    'route' => 'admin.news.edit',
                    'routeKey' => 'id',
                ],
                'delete' => [
                    'enabled' => true,
                    'btnClass' => 'delete-news-btn',
                ],
            ],
        ];
    }

    /**
     * Search and filter news for admin panel with pagination
     */
    public static function searchAdminNews($request)
    {
        $query = self::query();

        // Search by title
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Filter by datepublish date range
        if ($request->filled('datepublish')) {
            $dates = explode(' - ', $request->datepublish);
            if (count($dates) == 2) {
                try {
                    $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[0]))->startOfDay();
                    $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('datepublish', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    // Invalid date format, skip filter
                }
            }
        }

        // Search by publisher
        if ($request->filled('publisher')) {
            $query->where('publisher', 'like', '%' . $request->publisher . '%');
        }

        // Search by reporter
        if ($request->filled('reporter')) {
            $query->where('reporter', 'like', '%' . $request->reporter . '%');
        }

        // Search by editor
        if ($request->filled('editor')) {
            $query->where('editor', 'like', '%' . $request->editor . '%');
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
     * Save new news
     */
    public static function saveModel($request)
    {
        $gdriveService = new GoogleDrive(self::$pathNewsGDrive);

        $fileName = time() . '_news_' . $request->file('picture')->getClientOriginalName();
        $filePath = self::$pathNewsGDrive . '/' . $fileName;

        $uploadResult = $gdriveService->uploadImage($request->file('picture'), $fileName, $filePath);

        return self::create([
            'datepublish' => $request->datepublish,
            'publisher' => $request->publisher,
            'title' => $request->title,
            'reporter' => $request->reporter,
            'editor' => $request->editor,
            'picture' => $uploadResult['fileName'],
            'gdrive_id' => $uploadResult['gdriveID'],
            'descpicture' => $request->descpicture,
            'body' => $request->body,
        ]);
    }

    /**
     * Update existing news
     */
    public function updateModel($request)
    {
        if ($request->hasFile('picture')) {
            $gdriveService = new GoogleDrive(self::$pathNewsGDrive);

            $fileName = time() . '_news_' . $request->file('picture')->getClientOriginalName();
            $filePath = self::$pathNewsGDrive . '/' . $fileName;

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

        return $this->update([
            'datepublish' => $request->datepublish,
            'publisher' => $request->publisher,
            'title' => $request->title,
            'reporter' => $request->reporter,
            'editor' => $request->editor,
            'descpicture' => $request->descpicture,
            'body' => $request->body,
        ]);
    }

    /**
     * Delete news and its image
     */
    public function deleteModel()
    {
        if ($this->gdrive_id) {
            $gdriveService = new GoogleDrive(self::$pathNewsGDrive);
            $gdriveService->deleteImage($this->gdrive_id);
        }

        return $this->delete();
    }

    /**
     * Bulk delete news
     */
    public static function bulkDeleteModel(array $ids): int
    {
        $news = self::whereIn('id', $ids)->get();
        $gdriveService = new GoogleDrive(self::$pathNewsGDrive);

        foreach ($news as $item) {
            if ($item->gdrive_id) {
                $gdriveService->deleteImage($item->gdrive_id);
            }
        }

        return self::whereIn('id', $ids)->delete();
    }

    /**
     * Get picture URL from Google Drive
     */
    public function getPictureUrl()
    {
        if ($this->gdrive_id) {
            return 'https://lh3.googleusercontent.com/d/' . $this->gdrive_id;
        }
        return 'https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm';
    }
}
