<?php

namespace App\Models;

use App\Services\GoogleDrive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Article extends Model
{
    use HasFactory;

    // Google Drive folder ID for article posters
    public const PATH_ARTICLE_GDRIVE_ID = '1dSj_B3bkhbCM1S4CuZtO4-6Hq00sHdpD';

    protected $table = 'articles';
    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $casts = [
        'dateevent' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Allowed sort columns
     */
    protected static array $allowedSorts = [
        'title',
        'theme',
        'dateevent',
        'writer',
        'editor',
        'created_at'
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function articlecomments()
    {
        return $this->hasMany('App\Models\ArticleComment', 'articles_id');
    }

    /**
     * Get table configuration for admin index table component
     */
    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'No articles found',
            'emptyIcon' => 'fa-newspaper',
            'colspan' => 8,
            'columns' => [
                [
                    'key' => 'title',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'theme',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'dateevent',
                    'type' => 'date',
                    'class' => 'text-center',
                    'dateFormat' => 'DD MMMM YYYY',
                ],
                [
                    'key' => 'writer',
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
                    'route' => 'admin.article.preview',
                    'routeKey' => 'id',
                ],
                'edit' => [
                    'enabled' => true,
                    'type' => 'link',
                    'route' => 'admin.article.edit',
                    'routeKey' => 'id',
                ],
                'delete' => [
                    'enabled' => true,
                    'btnClass' => 'delete-article-btn',
                ],
            ],
        ];
    }

    /**
     * Search and filter articles for admin panel with pagination
     */
    public static function searchAdminArticles(Request $request)
    {
        $query = self::query();

        // Search by title
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Search by theme
        if ($request->filled('theme')) {
            $query->where('theme', 'like', '%' . $request->theme . '%');
        }

        // Search by writer
        if ($request->filled('writer')) {
            $query->where('writer', 'like', '%' . $request->writer . '%');
        }

        // Search by editor
        if ($request->filled('editor')) {
            $query->where('editor', 'like', '%' . $request->editor . '%');
        }

        // Filter by publish date range
        if ($request->filled('dateevent')) {
            $dates = explode(' - ', $request->dateevent);
            if (count($dates) == 2) {
                try {
                    $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[0]))->startOfDay();
                    $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('dateevent', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    // Invalid date format, skip filter
                }
            }
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
        $sortBy = $request->input('sort_by', 'dateevent');
        $sortOrder = $request->input('sort_order', 'desc');

        if (!in_array($sortBy, static::$allowedSorts)) {
            $sortBy = 'dateevent';
        }

        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate(15)->appends($request->query());
    }

    /**
     * Save new article
     */
    public static function saveModel(Request $request): self
    {
        $gdriveService = new GoogleDrive(self::PATH_ARTICLE_GDRIVE_ID);

        $fileName = time() . '_article_' . $request->file('poster')->getClientOriginalName();
        $filePath = self::PATH_ARTICLE_GDRIVE_ID . '/' . $fileName;

        $uploadResult = $gdriveService->uploadImage($request->file('poster'), $fileName, $filePath);

        return self::create([
            'title' => $request->title,
            'theme' => $request->theme,
            'dateevent' => $request->datearticle,
            'writer' => $request->writer,
            'editor' => $request->editor,
            'poster' => $uploadResult['fileName'],
            'gdrive_id' => $uploadResult['gdriveID'],
            'embedpdf' => $request->embedpdf,
        ]);
    }

    /**
     * Update existing article
     */
    public function updateModel(Request $request): self
    {
        if ($request->hasFile('poster')) {
            $gdriveService = new GoogleDrive(self::PATH_ARTICLE_GDRIVE_ID);

            $fileName = time() . '_article_' . $request->file('poster')->getClientOriginalName();
            $filePath = self::PATH_ARTICLE_GDRIVE_ID . '/' . $fileName;

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
            'theme' => $request->theme,
            'dateevent' => $request->datearticle,
            'writer' => $request->writer,
            'editor' => $request->editor,
            'embedpdf' => $request->embedpdf,
        ]);

        return $this;
    }

    /**
     * Delete article and its image from Google Drive
     */
    public function deleteModel(): bool
    {
        if ($this->gdrive_id) {
            $gdriveService = new GoogleDrive(self::PATH_ARTICLE_GDRIVE_ID);
            $gdriveService->deleteImage($this->gdrive_id);
        }

        return $this->delete();
    }

    /**
     * Bulk delete articles
     */
    public static function bulkDeleteModel(array $ids): int
    {
        $articles = self::whereIn('id', $ids)->get();
        $gdriveService = new GoogleDrive(self::PATH_ARTICLE_GDRIVE_ID);

        foreach ($articles as $article) {
            if ($article->gdrive_id) {
                $gdriveService->deleteImage($article->gdrive_id);
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
            return "https://lh3.googleusercontent.com/d/{$this->gdrive_id}";
        }
        return null;
    }
}
