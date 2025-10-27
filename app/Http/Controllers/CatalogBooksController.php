<?php

namespace App\Http\Controllers;

use App\Models\MsCatalogBook;
use App\Models\LkBookCategory;
use App\Models\LkLanguage;
use App\Models\LkAuthorType;
use App\Models\LkAvailabilityType;
use Illuminate\Http\Request;

class CatalogBooksController extends Controller
{
    /* =========================================================================
       SECTION A — LANDING PAGE (Public)
       ========================================================================= */

    public function index(Request $request)
    {
        $query = MsCatalogBook::searchIndexBooks($request);

        $books = $query->paginate(8)->withQueryString();

        $categories = LkBookCategory::select('bookCategoryID', 'bookCategoryName')->distinct()->orderBy('bookCategoryName')->get();
        $authors = MsCatalogBook::select('authorName')->distinct()->orderBy('authorName')->pluck('authorName');
        $publishers = MsCatalogBook::select('publisherName')->distinct()->orderBy('publisherName')->pluck('publisherName');
        $years = MsCatalogBook::select('year')->distinct()->orderByDesc('year')->pluck('year');
        $languages = LkLanguage::select('languageID', 'languageName')->distinct()->orderBy('languageName')->get();
        $authorTypes = LkAuthorType::select('authorTypeID', 'authorTypeName')->distinct()->orderBy('authorTypeName')->get();
        $availabilityTypes = LkAvailabilityType::select('availabilityTypeID', 'availabilityTypeName')->distinct()->orderBy('availabilityTypeName')->get();

        return view('landing-page.catalog-book.index', compact('books', 'categories', 'authors', 'publishers', 'years', 'languages', 'authorTypes', 'availabilityTypes'), [
            "title" => "Perpustakaan",
        ]);
    }

    public function show($slug)
    {
        $book = MsCatalogBook::where('slug', $slug)->firstOrFail();

        return view('landing-page.catalog-book.detail', compact('book'), [
            "title" => $book->titleBook,
        ]);
    }

    /* =========================================================================
       SECTION B — ADMIN AREA (with RESTful routing)
       ========================================================================= */
    public function indexAdmin(Request $request)
    {
        $books = MsCatalogBook::searchAdminBooks($request);
        $bookCategories = LkBookCategory::all();

        if ($request->ajax()) {
            return response()->json([
                'tableBody' => view('admin-page.catalog-book.components._index._index-table', compact('books'))->render(),
                'pagination' => $books->appends($request->query())->links()->render(),
                'total' => $books->total(),
                'from' => $books->firstItem(),
                'to' => $books->lastItem()
            ]);
        }

        return view('admin-page.catalog-book.index', compact('books', 'bookCategories'))
            ->with('title', 'Book Catalog');
    }

    public function create()
    {
        $languages = LkLanguage::all();
        $bookCategories = LkBookCategory::all();
        $authorTypes = LkAuthorType::all();
        $availabilityTypes = LkAvailabilityType::all();

        return view('admin-page.catalog-book.create', compact('languages', 'bookCategories', 'authorTypes', 'availabilityTypes'))
            ->with('title', 'Book Catalog');
    }

    public function store(Request $request)
    {
        MsCatalogBook::validateRequest($request);

        try {
            MsCatalogBook::saveModel($request);

            return redirect()->route('admin.catalog.books.indexAdmin')
                ->with('success', 'Book has been added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('failed', true)
                ->withErrors(['error' => 'Error adding book: ' . $e->getMessage()]);
        }
    }

    public function showAdmin(MsCatalogBook $book)
    {
        $languages = LkLanguage::all();
        $bookCategories = LkBookCategory::all();
        $authorTypes = LkAuthorType::all();
        $availabilityTypes = LkAvailabilityType::all();
        $book->load('getLanguage', 'getBookCategory', 'getAuthorType', 'getAvailabilityType');

        return view('admin-page.catalog-book.view', compact('book', 'languages', 'bookCategories', 'authorTypes', 'availabilityTypes'))
            ->with('title', 'Book Catalog');
    }

    public function edit(MsCatalogBook $book)
    {
        $languages = LkLanguage::all();
        $bookCategories = LkBookCategory::all();
        $authorTypes = LkAuthorType::all();
        $availabilityTypes = LkAvailabilityType::all();
        $book->load('getLanguage', 'getBookCategory', 'getAuthorType', 'getAvailabilityType');

        return view('admin-page.catalog-book.edit', compact('book', 'languages', 'bookCategories', 'authorTypes', 'availabilityTypes'))
            ->with('title', 'Book Catalog');
    }

    public function update(Request $request, MsCatalogBook $book)
    {
        MsCatalogBook::validateRequest($request, $book->bookID);

        try {
            $book->updateModel($request);

            return redirect()->route('admin.catalog.books.indexAdmin')
                ->with('success', 'Book has been updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('failed', true)
                ->withErrors(['error' => 'Error updating book: ' . $e->getMessage()]);
        }
    }

    public function destroy(MsCatalogBook $book)
    {
        try {
            $book->deleteModel();

            return response()->json([
                'success' => true,
                'message' => 'Book has been deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting book: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No books selected for deletion'
                ], 400);
            }

            MsCatalogBook::bulkDeleteModel($ids);

            return response()->json([
                'success' => true,
                'message' => 'Selected books have been deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting books: ' . $e->getMessage()
            ], 500);
        }
    }
}
