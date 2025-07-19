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
        MsCatalogBook::validateRequest($request);

        try {
            MsCatalogBook::saveModel($request);

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
        try {
            $book->deleteBookWithFiles();

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

            MsCatalogBook::bulkDeleteBooks($ids);

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
