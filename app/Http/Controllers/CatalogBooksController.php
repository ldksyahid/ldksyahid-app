<?php

namespace App\Http\Controllers;

use App\Models\MsCatalogBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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

    public function indexAdmin()
    {

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

    /* =========================================================================
       SECTION C — Helpers
       ========================================================================= */

    protected function validateRequest(Request $request, $ignoreId = null)
    {

    }

    protected function generateSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (
            MsCatalogBook::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }
}
