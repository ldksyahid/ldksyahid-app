<?php

namespace App\Http\Controllers;

use App\Models\MsCatalogBook;
use App\Services\GoogleDrive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CatalogBooksController extends Controller
{
    /* =========================================================================
       SECTION A — LANDING PAGE (Public)
       ========================================================================= */

    public function index()
    {

    }

    public function show($slug)
    {

    }

    /* =========================================================================
       SECTION B — ADMIN AREA (with RESTful routing)
       ========================================================================= */
    public function indexAdmin(Request $request)
    {
        $books = MsCatalogBook::searchAdminBooks($request);

        return view('admin-page.catalog-book.index', compact('books'))
            ->with('title', 'Book Catalog');
    }


    public function create()
    {
        return view('admin-page.catalog-book._form')
            ->with('title', 'Book Catalog');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'required|string|max:20',
            'titleBook' => 'required|string|max:255',
            'authorName' => 'required|string|max:100',
            'publisherName' => 'required|string|max:100',
            'categoryName' => 'required|string|max:100',
            'language' => 'required|string|max:50',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'pages' => 'required|integer|min:1',
            'description' => 'required|string',
            'synopsis' => 'nullable|string',
            'edition' => 'nullable|string|max:50',
            'coverImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdfFileName' => 'required|file|mimes:pdf|max:10240',
            'tags' => 'nullable|string|max:255',
            'metaKeywords' => 'nullable|string|max:255',
            'metaDescription' => 'nullable|string|max:255',
        ]);

        try {
            $slug = MsCatalogBook::generateSlug($request->titleBook);

            $coverImageFileName = null;
            $coverImageGDriveID = null;
            if ($request->hasFile('coverImage')) {
                $file = $request->file('coverImage');
                $fileName = time() . '_cover_' . $file->getClientOriginalName();
                $gdriveService = new GoogleDrive(MsCatalogBook::PATH_COVER_IMAGE_GDRIVE_ID);
                $uploadResult = $gdriveService->uploadImage($file, $fileName, MsCatalogBook::PATH_COVER_IMAGE_GDRIVE_ID . '/' . $fileName);
                $coverImageFileName = $uploadResult['fileName'];
                $coverImageGDriveID = $uploadResult['gdriveID'];
            }

            $pdfFileName = null;
            $pdfFileGDriveID = null;
            if ($request->hasFile('pdfFileName')) {
                $file = $request->file('pdfFileName');
                $fileName = time() . '_book_' . $file->getClientOriginalName();
                $gdriveService = new GoogleDrive(MsCatalogBook::PATH_PDF_FILE_NAME_GDRIVE_ID);
                $uploadResult = $gdriveService->uploadFile($file, $fileName, MsCatalogBook::PATH_PDF_FILE_NAME_GDRIVE_ID . '/' . $fileName);
                $pdfFileName = $uploadResult['fileName'];
                $pdfFileGDriveID = $uploadResult['gdriveID'];
            }

            $book = new MsCatalogBook();
            $book->slug = $slug;
            $book->isbn = $request->isbn;
            $book->titleBook = $request->titleBook;
            $book->authorName = $request->authorName;
            $book->publisherName = $request->publisherName;
            $book->categoryName = $request->categoryName;
            $book->language = $request->language;
            $book->year = $request->year;
            $book->pages = $request->pages;
            $book->description = $request->description;
            $book->synopsis = $request->synopsis;
            $book->edition = $request->edition;
            $book->coverImage = $coverImageFileName;
            $book->coverImageGdriveID = $coverImageGDriveID;
            $book->pdfFileName = $pdfFileName;
            $book->pdfFileNameGdriveID = $pdfFileGDriveID;
            $book->tags = $request->tags;
            $book->metaKeywords = $request->metaKeywords;
            $book->metaDescription = $request->metaDescription;
            $book->flagActive = $request->has('flagActive') ? 1 : 0;
            $book->save();

            return redirect()->route('admin.catalog.books.indexAdmin')
                ->with('success', 'Book has been added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error adding book: ' . $e->getMessage()]);
        }
    }

    public function showAdmin(MsCatalogBook $book)
    {

    }

    public function edit(MsCatalogBook $book)
    {

    }

    public function update(Request $request, MsCatalogBook $book)
    {

    }

    public function destroy(MsCatalogBook $book)
    {

    }

    public function bulkDelete(Request $request)
    {

    }
}
