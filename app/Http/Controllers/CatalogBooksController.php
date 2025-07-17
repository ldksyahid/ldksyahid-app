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
        $search     = $request->input('search');
        $sortBy     = $request->input('sort_by', 'createdDate');
        $sortOrder  = $request->input('sort_order', 'desc');

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

        $books = MsCatalogBook::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('titleBook', 'like', "%{$search}%")
                    ->orWhere('authorName', 'like', "%{$search}%")
                    ->orWhere('publisherName', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%")
                    ->orWhere('categoryName', 'like', "%{$search}%")
                    ->orWhere('language', 'like', "%{$search}%")
                    ->orWhere('tags', 'like', "%{$search}%");
            });
        })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(15)
            ->appends($request->all());

        return view('admin-page.catalog-book.index', compact('books'))
            ->with('title', 'Book Catalog');
    }


    public function create()
    {

    }

    public function store(Request $request)
    {

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
