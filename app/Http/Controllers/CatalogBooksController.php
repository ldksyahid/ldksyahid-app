<?php

namespace App\Http\Controllers;

use App\Models\MsCatalogBook;
use Illuminate\Http\Request;
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
        try {
            // Validasi input
            $validated = $request->validate([
                'isbn' => 'required|string|max:20',
                'titleBook' => 'required|string|max:255',
                'authorName' => 'required|string|max:100',
                'publisherName' => 'required|string|max:100',
                'categoryName' => 'required|string|max:100',
                'language' => 'required|string|max:50',
                'year' => 'required|integer|min:1900|max:' . date('Y'),
                'pages' => 'nullable|integer|min:1',
                'description' => 'nullable|string',
                'synopsis' => 'nullable|string',
                'edition' => 'nullable|string|max:50',
                'coverImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'coverImageGdriveID' => 'nullable|string|max:255',
                'pdfFileName' => 'nullable|file|mimes:pdf|max:10240',
                'pdfFileNameGdriveID' => 'nullable|string|max:255',
                'tags' => 'nullable|string|max:255',
                'metaKeywords' => 'nullable|string|max:255',
                'metaDescription' => 'nullable|string|max:255',
                'flagActive' => 'boolean',
            ]);

            // Generate slug dari title
            $slug = MsCatalogBook::generateSlug($request->titleBook);

            // Handle file uploads
            $coverImagePath = null;
            if ($request->hasFile('coverImage')) {
                $coverImagePath = $request->file('coverImage')->store('public/book-covers');
                $coverImagePath = str_replace('public/', '', $coverImagePath);
            }

            $pdfFilePath = null;
            if ($request->hasFile('pdfFileName')) {
                $pdfFilePath = $request->file('pdfFileName')->store('public/book-pdfs');
                $pdfFilePath = str_replace('public/', '', $pdfFilePath);
            }

            // Buat data buku baru
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
            $book->coverImage = $coverImagePath;
            $book->coverImageGdriveID = $request->coverImageGdriveID;
            $book->pdfFileName = $pdfFilePath;
            $book->pdfFileNameGdriveID = $request->pdfFileNameGdriveID;
            $book->tags = $request->tags;
            $book->metaKeywords = $request->metaKeywords;
            $book->metaDescription = $request->metaDescription;
            $book->flagActive = $request->has('flagActive') ? 1 : 0;
            $book->save();

            return redirect()->route('admin.catalog.books.indexAdmin')
                ->with('success', 'Book has been added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('failed', 'Error adding book: ' . $e->getMessage())
                ->withInput();
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
