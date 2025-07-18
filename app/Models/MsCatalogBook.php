<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MsCatalogBook extends Model
{
    public const PATH_PDF_FILE_NAME_GDRIVE_ID = '1ypgrC-wOqzGFZCxMapG4ULieMtfK752a';
    public const PATH_COVER_IMAGE_GDRIVE_ID = '1XeDE0FxSppCyaEZA-Vdzol4sLgERmx1p';

    protected $table = 'ms_catalog_book';
    protected $primaryKey = 'bookID';
    public $timestamps = false;

    protected $fillable = [
        'slug',
        'isbn',
        'titleBook',
        'authorName',
        'publisherName',
        'categoryName',
        'language',
        'year',
        'pages',
        'description',
        'synopsis',
        'edition',
        'coverImage',
        'coverImageGdriveID',
        'pdfFileName',
        'pdfFileNameGdriveID',
        'readCount',
        'downloadCount',
        'rating',
        'tags',
        'metaKeywords',
        'metaDescription',
        'flagActive',
        'createdBy',
        'createdDate',
        'editedBy',
        'editedDate',
    ];

    protected $casts = [
        'readCount' => 'integer',
        'downloadCount' => 'integer',
        'rating' => 'decimal:1',
        'flagActive' => 'boolean',
        'createdDate' => 'datetime',
        'editedDate' => 'datetime',
    ];

    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    public static function attributeLabels(): array
    {
        return [
            'bookID' => 'Book ID',
            'slug' => 'Slug',
            'isbn' => 'ISBN',
            'titleBook' => 'Title',
            'authorName' => 'Author',
            'publisherName' => 'Publisher',
            'categoryName' => 'Category',
            'language' => 'Language',
            'year' => 'Year',
            'pages' => 'Pages',
            'description' => 'Description',
            'synopsis' => 'Synopsis',
            'edition' => 'Edition',
            'coverImage' => 'Cover Image',
            'coverImageGdriveID' => 'Cover Image GDrive ID',
            'pdfFileName' => 'PDF File Name',
            'pdfFileNameGdriveID' => 'PDF File GDrive ID',
            'readCount' => 'Read Count',
            'downloadCount' => 'Download Count',
            'rating' => 'Rating',
            'tags' => 'Tags',
            'metaKeywords' => 'Meta Keywords',
            'metaDescription' => 'Meta Description',
            'flagActive' => 'Active',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->createdBy = auth()->check() ? auth()->user()->username : 'SYSTEM';
            $model->createdDate = now();
            $model->editedBy = auth()->check() ? auth()->user()->username : 'SYSTEM';
            $model->editedDate = now();
        });

        static::updating(function ($model) {
            $model->editedBy = auth()->check() ? auth()->user()->username : 'SYSTEM';
            $model->editedDate = now();
        });
    }


    public static function validateRequest(Request $request, $ignoreId = null) {

    }

    public static function generateSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (
            self::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('bookID', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }

    public static function searchAdminBooks(Request $request)
    {
        $sortBy = $request->input('sort_by', 'createdDate');
        $sortOrder = $request->input('sort_order', 'desc');

        $allowedSorts = [
            'isbn',
            'titleBook',
            'authorName',
            'publisherName',
            'categoryName',
            'language',
            'year',
            'pages',
            'readCount',
            'downloadCount',
            'rating',
            'createdBy',
            'createdDate',
        ];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'createdDate';
        }

        $query = self::query();

        if ($request->filled('isbn')) {
            $query->where('isbn', 'like', "%{$request->isbn}%");
        }

        if ($request->filled('title')) {
            $query->where('titleBook', 'like', "%{$request->title}%");
        }

        if ($request->filled('author')) {
            $query->where('authorName', 'like', "%{$request->author}%");
        }

        if ($request->filled('publisher')) {
            $query->where('publisherName', 'like', "%{$request->publisher}%");
        }

        if ($request->filled('category')) {
            $query->where('categoryName', 'like', "%{$request->category}%");
        }

        if ($request->filled('language')) {
            $query->where('language', 'like', "%{$request->language}%");
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('reads')) {
            $query->where('readCount', 'like', "%{$request->reads}%");
        }

        if ($request->filled('added_date')) {
            $dates = explode(' - ', $request->added_date);

            if (count($dates) == 2) {
                try {
                    $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', trim($dates[0]))->startOfDay();
                    $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', trim($dates[1]))->endOfDay();

                    $query->whereBetween('createdDate', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    $query->where('createdDate', 'like', "%{$request->added_date}%");
                }
            } else {
                $query->whereDate('createdDate', $request->added_date);
            }
        }

        return $query->orderBy($sortBy, $sortOrder)
            ->paginate(15)
            ->appends($request->all());
    }
}
