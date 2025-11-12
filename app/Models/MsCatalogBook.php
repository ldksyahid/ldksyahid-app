<?php

namespace App\Models;

use App\Services\GoogleDrive;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MsCatalogBook extends Model
{
    // Google Drive folder ID for cover images
    public const PATH_COVER_IMAGE_GDRIVE_ID = '1XeDE0FxSppCyaEZA-Vdzol4sLgERmx1p';

    protected $table = 'ms_catalog_book';
    protected $primaryKey = 'bookID';
    public $timestamps = false;

    // Mass assignable attributes
    protected $fillable = [
        'slug',
        'isbn',
        'titleBook',
        'authorName',
        'authorTypeID',
        'publisherName',
        'bookCategoryID',
        'languageID',
        'availabilityTypeID',
        'purchaseLink',
        'borrowLink',
        'readerLink',
        'year',
        'pages',
        'description',
        'synopsis',
        'edition',
        'coverImage',
        'coverImageGdriveID',
        'favoriteCount',
        'tags',
        'metaKeywords',
        'metaDescription',
        'flagActive',
        'createdBy',
        'createdDate',
        'editedBy',
        'editedDate',
    ];

    // Attribute casting
    protected $casts = [
        'readCount' => 'integer',
        'downloadCount' => 'integer',
        'rating' => 'decimal:1',
        'flagActive' => 'boolean',
        'createdDate' => 'datetime',
        'editedDate' => 'datetime',
    ];

    /**
     * Get the table name for the model
     */
    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    /**
     * Get attribute labels for forms and displays
     */
    public static function attributeLabels(): array
    {
        return [
            'bookID' => 'Book ID',
            'slug' => 'Slug',
            'isbn' => 'ISBN',
            'titleBook' => 'Title',
            'authorName' => 'Author Name',
            'authorTypeID' => 'Author Type',
            'publisherName' => 'Publisher',
            'bookCategoryID' => 'Book Category',
            'languageID' => 'Language',
            'availabilityTypeID' => 'Availability Type',
            'purchaseLink' => 'Purchase Link',
            'borrowLink' => 'Borrow Link',
            'readerLink' => 'AnyFlip Reader Link',
            'year' => 'Year',
            'pages' => 'Pages',
            'description' => 'Description',
            'synopsis' => 'Synopsis',
            'edition' => 'Edition',
            'coverImage' => 'Cover Image',
            'coverImageGdriveID' => 'Cover Image GDrive ID',
            'favoriteCount' => 'Favorite Count',
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

    /**
     * Relationship with book category
     */
    public function getBookCategory()
    {
        return $this->belongsTo(LkBookCategory::class, 'bookCategoryID', 'bookCategoryID');
    }

    /**
     * Relationship with language
     */
    public function getLanguage()
    {
        return $this->belongsTo(LkLanguage::class, 'languageID', 'languageID');
    }

    /**
     * Relationship with author type
     */
    public function getAuthorType()
    {
        return $this->belongsTo(LkAuthorType::class, 'authorTypeID', 'authorTypeID');
    }

    /**
     * Relationship with availability type
     */
    public function getAvailabilityType()
    {
        return $this->belongsTo(LkAvailabilityType::class, 'availabilityTypeID', 'availabilityTypeID');
    }

    /**
     * Boot method for model events
     */
    protected static function booted(): void
    {
        // Set createdBy and editedBy before creating
        static::creating(function ($model) {
            $model->createdBy = auth()->check() ? auth()->user()->username : 'SYSTEM';
            $model->createdDate = now();
            $model->editedBy = auth()->check() ? auth()->user()->username : 'SYSTEM';
            $model->editedDate = now();
        });

        // Set editedBy before updating
        static::updating(function ($model) {
            $model->editedBy = auth()->check() ? auth()->user()->username : 'SYSTEM';
            $model->editedDate = now();
        });
    }

    /**
     * Validate request data for create/update operations
     */
    public static function validateRequest(Request $request, $ignoreId = null): array
    {
        $maxYear = date('Y');

        $rules = [
            'isbn' => 'nullable|string|max:20',
            'titleBook' => 'required|string|max:255',
            'authorName' => 'required|string|max:100',
            'publisherName' => 'required|string|max:100',
            'bookCategoryID' => 'required|exists:lk_book_category,bookCategoryID',
            'languageID' => 'required|exists:lk_language,languageID',
            'authorTypeID' => 'required',
            'availabilityTypeID' => 'required',
            'year' => "required|integer|min:1900|max:$maxYear",
            'pages' => 'required|integer|min:1',
            'description' => 'required|string',
            'synopsis' => 'nullable|string',
            'edition' => 'nullable|string|max:50',
            'coverImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'readerLink' => 'nullable|string|max:500|url',
            'tags' => 'nullable|string|max:255',
            'metaKeywords' => 'nullable|string|max:255',
            'metaDescription' => 'nullable|string|max:255',
            'favoriteCount' => 'nullable|integer',
            'purchaseLink' => 'nullable|url|max:255',
            'borrowLink' => 'nullable|url|max:255',
        ];

        // Add unique validation rules
        if ($ignoreId === null) {
            $rules['isbn'] .= '|unique:ms_catalog_book,isbn';
            $rules['titleBook'] .= '|unique:ms_catalog_book,titleBook';
        } else {
            $rules['isbn'] .= '|unique:ms_catalog_book,isbn,' . $ignoreId . ',bookID';
            $rules['titleBook'] .= '|unique:ms_catalog_book,titleBook,' . $ignoreId . ',bookID';
        }

        return $request->validate($rules);
    }

    /**
     * Generate unique slug from title
     */
    public static function generateSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        // Ensure slug is unique
        while (
            self::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('bookID', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }

    /**
     * Search books for frontend index with filters and sorting
     */
    public static function searchIndexBooks(Request $request)
    {
        $query = self::with(['getBookCategory', 'getLanguage', 'getAuthorType', 'getAvailabilityType'])
                    ->where('flagActive', true);

        $sort = $request->input('sort', 'newest');

        // Apply sorting
        switch ($sort) {
            case 'newest':
                $query->orderBy('createdDate', 'desc');
                break;
            case 'popular':
                $query->orderBy('favoriteCount', 'desc')
                    ->orderBy('createdDate', 'desc');
                break;
            case 'title':
                $query->orderBy('titleBook', 'asc');
                break;
            default:
                $query->orderBy('createdDate', 'desc');
                break;
        }

        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titleBook', 'like', "%{$search}%")
                ->orWhere('authorName', 'like', "%{$search}%")
                ->orWhere('publisherName', 'like', "%{$search}%")
                ->orWhere('isbn', 'like', "%{$search}%")
                ->orWhere('year', $search);
            });
        }

        // Apply category filter
        if ($request->has('category')) {
            $categories = (array) $request->category;
            $filteredCategories = array_filter($categories, function($value) {
                return !is_null($value) && $value !== '';
            });
            if (!empty($filteredCategories)) {
                $query->whereIn('bookCategoryID', $filteredCategories);
            }
        }

        // Apply author filter
        if ($request->has('author')) {
            $authors = (array) $request->author;
            $filteredAuthors = array_filter($authors, function($value) {
                return !is_null($value) && $value !== '';
            });
            if (!empty($filteredAuthors)) {
                $query->whereIn('authorName', $filteredAuthors);
            }
        }

        // Apply publisher filter
        if ($request->has('publisher')) {
            $publishers = (array) $request->publisher;
            $filteredPublishers = array_filter($publishers, function($value) {
                return !is_null($value) && $value !== '';
            });
            if (!empty($filteredPublishers)) {
                $query->whereIn('publisherName', $filteredPublishers);
            }
        }

        // Apply year filter
        if ($request->has('year')) {
            $years = (array) $request->year;
            $filteredYears = array_filter($years, function($value) {
                return !is_null($value) && $value !== '';
            });
            if (!empty($filteredYears)) {
                $query->whereIn('year', $filteredYears);
            }
        }

        // Apply language filter
        if ($request->has('language')) {
            $languages = (array) $request->language;
            $filteredLanguages = array_filter($languages, function($value) {
                return !is_null($value) && $value !== '';
            });
            if (!empty($filteredLanguages)) {
                $query->whereIn('languageID', $filteredLanguages);
            }
        }

        // Apply author type filter
        if ($request->has('author_type')) {
            $authorTypes = (array) $request->author_type;
            $filteredAuthorTypes = array_filter($authorTypes, function($value) {
                return !is_null($value) && $value !== '';
            });
            if (!empty($filteredAuthorTypes)) {
                $query->whereIn('authorTypeID', $filteredAuthorTypes);
            }
        }

        // Apply availability filter
        if ($request->has('availability')) {
            $availabilities = (array) $request->availability;
            $filteredAvailabilities = array_filter($availabilities, function($value) {
                return !is_null($value) && $value !== '';
            });
            if (!empty($filteredAvailabilities)) {
                $query->whereIn('availabilityTypeID', $filteredAvailabilities);
            }
        }

        return $query;
    }

    /**
     * Search books for admin panel with advanced filters
     */
    public static function searchAdminBooks(Request $request)
    {
        $sortBy = $request->input('sort_by', 'createdDate');
        $sortOrder = $request->input('sort_order', 'desc');

        $allowedSorts = [
            'isbn',
            'titleBook',
            'authorName',
            'publisherName',
            'bookCategoryID',
            'year',
            'favoriteCount',
            'createdDate',
        ];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'createdDate';
        }

        $query = self::with(['getBookCategory']);

        // Apply various filters
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
            $query->whereHas('getBookCategory', function($q) use ($request) {
                $q->where('bookCategoryName', 'like', "%{$request->category}%");
            });
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('favorite_count')) {
            $query->where('favoriteCount', $request->favorite_count);
        }

        // Date range filter
        if ($request->filled('added_date')) {
            $dates = explode(' - ', $request->added_date);

            if (count($dates) == 2) {
                try {
                    $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[0]))->startOfDay();
                    $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[1]))->endOfDay();

                    $query->whereBetween('createdDate', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    $query->where('createdDate', 'like', "%{$request->added_date}%");
                }
            } else {
                $query->whereDate('createdDate', $request->added_date);
            }
        }

        // Special sorting for category name
        if ($sortBy === 'bookCategoryID') {
            $query->join('lk_book_category', 'ms_catalog_book.bookCategoryID', '=', 'lk_book_category.bookCategoryID')
                ->orderBy('lk_book_category.bookCategoryName', $sortOrder)
                ->select('ms_catalog_book.*');
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        return $query->orderBy($sortBy, $sortOrder)
            ->paginate(15)
            ->appends($request->all());
    }

    /**
     * Save new book model with cover image upload
     */
    public static function saveModel(Request $request): self
    {
        $slug = self::generateSlug($request->titleBook);

        $coverImageFileName = null;
        $coverImageGDriveID = null;

        // Handle cover image upload to Google Drive
        if ($request->hasFile('coverImage')) {
            $file = $request->file('coverImage');
            $fileName = time() . '_cover_' . $file->getClientOriginalName();
            $gdriveService = new GoogleDrive(self::PATH_COVER_IMAGE_GDRIVE_ID);
            $uploadResult = $gdriveService->uploadImage($file, $fileName, self::PATH_COVER_IMAGE_GDRIVE_ID . '/' . $fileName);
            $coverImageFileName = $uploadResult['fileName'];
            $coverImageGDriveID = $uploadResult['gdriveID'];
        }

        return self::create([
            'slug' => $slug,
            'isbn' => $request->isbn,
            'titleBook' => $request->titleBook,
            'authorName' => $request->authorName,
            'publisherName' => $request->publisherName,
            'bookCategoryID' => $request->bookCategoryID,
            'languageID' => $request->languageID,
            'authorTypeID' => $request->authorTypeID,
            'availabilityTypeID' => $request->availabilityTypeID,
            'year' => $request->year,
            'pages' => $request->pages,
            'description' => $request->description,
            'synopsis' => $request->synopsis,
            'edition' => $request->edition,
            'coverImage' => $coverImageFileName,
            'coverImageGdriveID' => $coverImageGDriveID,
            'readerLink' => $request->readerLink,
            'tags' => $request->tags,
            'metaKeywords' => $request->metaKeywords,
            'metaDescription' => $request->metaDescription,
            'favoriteCount' => 0,
            'purchaseLink' => $request->purchaseLink,
            'borrowLink' => $request->borrowLink,
            'flagActive' => 1,
        ]);
    }

    /**
     * Get cover image URL from Google Drive
     */
    public function coverImageUrl()
    {
        if ($this->coverImageGdriveID) {
            $gdriveService = new GoogleDrive(self::PATH_COVER_IMAGE_GDRIVE_ID);
            return $gdriveService->getImageUrl($this->coverImageGdriveID);
        }
        return null;
    }

    /**
     * Update book model with optional cover image replacement
     */
    public function updateModel(Request $request): void
    {
        $data = $request->all();

        // Handle cover image update
        if ($request->hasFile('coverImage')) {
            if ($this->coverImageGdriveID) {
                $this->deleteFilesFromDrive([$this->coverImageGdriveID], self::PATH_COVER_IMAGE_GDRIVE_ID);
            }

            $file = $request->file('coverImage');
            $fileName = time() . '_cover_' . $file->getClientOriginalName();
            $gdriveService = new GoogleDrive(self::PATH_COVER_IMAGE_GDRIVE_ID);
            $uploadResult = $gdriveService->uploadImage($file, $fileName, self::PATH_COVER_IMAGE_GDRIVE_ID . '/' . $fileName);
            $data['coverImage'] = $uploadResult['fileName'];
            $data['coverImageGdriveID'] = $uploadResult['gdriveID'];
        }

        $this->update($data);
    }

    /**
     * Delete book model and associated files
     */
    public function deleteModel(): void
    {
        try {
            $this->deleteFilesFromDrive();
            $this->delete();
        } catch (\Exception $e) {
            Log::error("Error deleting book ID {$this->bookID}: " . $e->getMessage());
            throw new \Exception('Failed to delete book and its files');
        }
    }

    /**
     * Bulk delete multiple books
     */
    public static function bulkDeleteModel(array $ids): void
    {
        try {
            $books = self::whereIn('bookID', $ids)->get();

            foreach ($books as $book) {
                $book->deleteModel();
            }
        } catch (\Exception $e) {
            Log::error("Error bulk deleting books: " . $e->getMessage());
            throw new \Exception('Failed to delete selected books');
        }
    }

    /**
     * Delete associated files from Google Drive
     */
    protected function deleteFilesFromDrive(): void
    {
        try {
            if ($this->coverImageGdriveID) {
                $gdriveService = new GoogleDrive(self::PATH_COVER_IMAGE_GDRIVE_ID);
                $gdriveService->deleteImage($this->coverImageGdriveID);
            }
        } catch (\Exception $e) {
            Log::error("Error deleting files for book ID {$this->bookID}: " . $e->getMessage());
            throw new \Exception('Failed to delete associated files');
        }
    }

    /**
     * Increment favorite count for a book
     */
    public static function incrementFavoriteCount($bookID)
    {
        try {
            $book = self::find($bookID);
            if ($book) {
                $book->increment('favoriteCount');
                return $book->favoriteCount;
            }
            return false;
        } catch (\Exception $e) {
            Log::error("Error incrementing favorite count for book ID {$bookID}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if AnyFlip reader link is available
     */
    public function isReaderLinkAvailable(): bool
    {
        return !empty($this->readerLink);
    }

    /**
     * Get AnyFlip reader link
     */
    public function getReaderLink(): ?string
    {
        return $this->readerLink;
    }

    /**
     * Get formatted AnyFlip reader link (ensure proper URL format with online.anyflip.com)
     */
    public function getFormattedReaderLink(): ?string
    {
        if (!$this->readerLink) {
            return null;
        }

        $formattedLink = $this->readerLink;

        // If full AnyFlip online URL is provided, return as is
        if (str_starts_with($formattedLink, 'https://online.anyflip.com/')) {
            return $formattedLink;
        }

        // If regular anyflip.com URL, convert to online.anyflip.com
        if (str_starts_with($formattedLink, 'https://anyflip.com/')) {
            $formattedLink = str_replace('https://anyflip.com/', 'https://online.anyflip.com/', $formattedLink);
            return $formattedLink;
        }

        // If only domain and path, add https protocol with online subdomain
        if (str_starts_with($formattedLink, 'anyflip.com/')) {
            $formattedLink = 'https://online.' . $formattedLink;
            return $formattedLink;
        }

        // If only path code (like "ueiyz/zcmp"), add full online domain
        if (preg_match('/^[a-z]+\/[a-z]+$/i', $formattedLink)) {
            $formattedLink = 'https://online.anyflip.com/' . $formattedLink;
            return $formattedLink;
        }

        // For online.anyflip.com without https
        if (str_starts_with($formattedLink, 'online.anyflip.com/')) {
            $formattedLink = 'https://' . $formattedLink;
            return $formattedLink;
        }

        // Default: return as is (should be full URL)
        return $formattedLink;
    }

    /**
     * Check if this book has AnyFlip embeddable content
     */
    public function hasAnyFlipContent(): bool
    {
        return $this->isReaderLinkAvailable() &&
               str_contains($this->readerLink, 'anyflip.com');
    }

    /**
     * Get AnyFlip embed URL (if available)
     */
    public function getAnyFlipEmbedUrl(): ?string
    {
        if (!$this->hasAnyFlipContent()) {
            return null;
        }

        $readerLink = $this->getFormattedReaderLink();

        // AnyFlip usually provides embed through the same URL
        // or by adding embed parameter
        return $readerLink . (str_contains($readerLink, '?') ? '&embed=true' : '?embed=true');
    }
}
