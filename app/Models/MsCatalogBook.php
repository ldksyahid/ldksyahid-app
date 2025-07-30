<?php

namespace App\Models;

use App\Services\GoogleDrive;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
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

    protected static function booted(): void
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


    public static function validateRequest(Request $request, $ignoreId = null): array
    {
        $maxYear = date('Y');

        return $request->validate([
            'isbn' => 'required|string|max:20|unique:ms_catalog_book,isbn',
            'titleBook' => 'required|string|max:255|unique:ms_catalog_book,titleBook',
            'authorName' => 'required|string|max:100',
            'publisherName' => 'required|string|max:100',
            'categoryName' => 'required|string|max:100',
            'language' => 'required|string|max:50',
            'year' => "required|integer|min:1900|max:$maxYear",
            'pages' => 'required|integer|min:1',
            'description' => 'required|string',
            'synopsis' => 'nullable|string',
            'edition' => 'nullable|string|max:50',
            'coverImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdfFileName' => 'required|file|mimes:pdf|max:10240',
            'tags' => 'nullable|string|max:255',
            'metaKeywords' => 'nullable|string|max:255',
            'metaDescription' => 'nullable|string|max:255',
        ]);
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

    public static function searchAdminBooks(Request $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
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

    public static function saveModel(Request $request): self
    {
        $slug = self::generateSlug($request->titleBook);

        $coverImageFileName = null;
        $coverImageGDriveID = null;
        if ($request->hasFile('coverImage')) {
            $file = $request->file('coverImage');
            $fileName = time() . '_cover_' . $file->getClientOriginalName();
            $gdriveService = new GoogleDrive(self::PATH_COVER_IMAGE_GDRIVE_ID);
            $uploadResult = $gdriveService->uploadImage($file, $fileName, self::PATH_COVER_IMAGE_GDRIVE_ID . '/' . $fileName);
            $coverImageFileName = $uploadResult['fileName'];
            $coverImageGDriveID = $uploadResult['gdriveID'];
        }

        $pdfFileName = null;
        $pdfFileGDriveID = null;
        if ($request->hasFile('pdfFileName')) {
            $file = $request->file('pdfFileName');
            $fileName = time() . '_book_' . $file->getClientOriginalName();
            $gdriveService = new GoogleDrive(self::PATH_PDF_FILE_NAME_GDRIVE_ID);
            $uploadResult = $gdriveService->uploadFile($file, $fileName, self::PATH_PDF_FILE_NAME_GDRIVE_ID . '/' . $fileName);
            $pdfFileName = $uploadResult['fileName'];
            $pdfFileGDriveID = $uploadResult['gdriveID'];
        }

        return self::create([
            'slug' => $slug,
            'isbn' => $request->isbn,
            'titleBook' => $request->titleBook,
            'authorName' => $request->authorName,
            'publisherName' => $request->publisherName,
            'categoryName' => $request->categoryName,
            'language' => $request->language,
            'year' => $request->year,
            'pages' => $request->pages,
            'description' => $request->description,
            'synopsis' => $request->synopsis,
            'edition' => $request->edition,
            'coverImage' => $coverImageFileName,
            'coverImageGdriveID' => $coverImageGDriveID,
            'pdfFileName' => $pdfFileName,
            'pdfFileNameGdriveID' => $pdfFileGDriveID,
            'tags' => $request->tags,
            'metaKeywords' => $request->metaKeywords,
            'metaDescription' => $request->metaDescription,
            'flagActive' => $request->has('flagActive') ? 1 : 0,
        ]);
    }

    public function coverImageUrl()
    {
        if ($this->coverImageGdriveID) {
            $gdriveService = new GoogleDrive(self::PATH_COVER_IMAGE_GDRIVE_ID);
            return $gdriveService->getImageUrl($this->coverImageGdriveID);
        }
        return null;
    }

    public function pdfFileUrl()
    {
        if ($this->pdfFileNameGdriveID) {
            $gdriveService = new GoogleDrive(self::PATH_PDF_FILE_NAME_GDRIVE_ID);
            return $gdriveService->getFileUrl($this->pdfFileNameGdriveID);
        }
        return null;
    }

    public function updateModel(Request $request): void
    {
        $data = $request->all();

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

        if ($request->hasFile('pdfFileName')) {
            if ($this->pdfFileNameGdriveID) {
                $this->deleteFilesFromDrive([$this->pdfFileNameGdriveID], self::PATH_PDF_FILE_NAME_GDRIVE_ID);
            }

            $file = $request->file('pdfFileName');
            $fileName = time() . '_book_' . $file->getClientOriginalName();
            $gdriveService = new GoogleDrive(self::PATH_PDF_FILE_NAME_GDRIVE_ID);
            $uploadResult = $gdriveService->uploadFile($file, $fileName, self::PATH_PDF_FILE_NAME_GDRIVE_ID . '/' . $fileName);
            $data['pdfFileName'] = $uploadResult['fileName'];
            $data['pdfFileNameGdriveID'] = $uploadResult['gdriveID'];
        }

        $this->update($data);
    }


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

    protected function deleteFilesFromDrive(): void
    {
        try {
            if ($this->coverImageGdriveID) {
                $gdriveService = new GoogleDrive(self::PATH_COVER_IMAGE_GDRIVE_ID);
                $gdriveService->deleteImage($this->coverImageGdriveID);
            }

            if ($this->pdfFileNameGdriveID) {
                $gdriveService = new GoogleDrive(self::PATH_PDF_FILE_NAME_GDRIVE_ID);
                $gdriveService->deleteFile($this->pdfFileNameGdriveID);
            }
        } catch (\Exception $e) {
            Log::error("Error deleting files for book ID {$this->bookID}: " . $e->getMessage());
            throw new \Exception('Failed to delete associated files');
        }
    }
}
