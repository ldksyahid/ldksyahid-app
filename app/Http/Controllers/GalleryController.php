<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use RealRashid\SweetAlert\Facades\Alert;

class GalleryController extends Controller
{
    /**
     * Landing page - Display all galleries
     */
    public function index()
    {
        $postgallery = Gallery::orderBy('created_at', 'desc')->get();
        return view('landing-page.about.gallery', compact('postgallery'), ["title" => "Tentang Kami"]);
    }

    /**
     * Admin - Display gallery list with AJAX support
     */
    public function indexAdmin(Request $request)
    {
        $items = Gallery::searchAdminGalleries($request);
        $tableConfig = Gallery::getTableConfig();

        // Get select2 options
        $eventNameOptions = Gallery::getEventNameOptions();
        $eventThemeOptions = Gallery::getEventThemeOptions();

        if ($request->ajax()) {
            return response()->json([
                'tableBody' => view('components.admin-index.index-table', [
                    'items' => $items,
                    'tableConfig' => $tableConfig,
                ])->render(),
                'pagination' => $items->appends($request->query())->links()->render(),
                'total' => $items->total(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem()
            ]);
        }

        return view('admin-page.about.gallery.index', compact('items', 'tableConfig', 'eventNameOptions', 'eventThemeOptions'))
            ->with('title', 'Gallery');
    }

    /**
     * Admin - Show create form
     */
    public function create()
    {
        return view('admin-page.about.gallery.create')
            ->with('title', 'Gallery');
    }

    /**
     * Admin - Store new gallery
     */
    public function store(Request $request)
    {
        $request->validate([
            'eventName' => 'required|string|max:255',
            'eventTheme' => 'required|string|max:255',
            'eventDescription' => 'required|string',
            'groupPhoto' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'linkEmbedYoutube' => 'nullable|url',
            'linkDoc' => 'nullable|url',
        ]);

        try {
            Gallery::saveModel($request);
            Alert::success('Success', 'Gallery has been created!');
            return redirect()->route('admin.about.gallery.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to create gallery: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Admin - Show edit form
     */
    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);

        return view('admin-page.about.gallery.update', compact('gallery'))
            ->with('title', 'Gallery');
    }

    /**
     * Admin - Show gallery detail (view mode)
     */
    public function showAdmin($id)
    {
        $gallery = Gallery::findOrFail($id);

        return view('admin-page.about.gallery.view', compact('gallery'))
            ->with('title', 'Gallery');
    }

    /**
     * Admin - Update gallery
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'eventName' => 'required|string|max:255',
            'eventTheme' => 'required|string|max:255',
            'eventDescription' => 'required|string',
            'groupPhoto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'linkEmbedYoutube' => 'nullable|url',
            'linkDoc' => 'nullable|url',
        ]);

        try {
            $gallery = Gallery::findOrFail($id);
            $gallery->updateModel($request);
            Alert::success('Success', 'Gallery has been updated!');
            return redirect()->route('admin.about.gallery.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update gallery: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Admin - Delete gallery
     */
    public function destroy($id)
    {
        try {
            $gallery = Gallery::findOrFail($id);
            $gallery->deleteModel();

            return response()->json([
                'success' => true,
                'message' => 'Gallery has been deleted!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting gallery: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin - Bulk delete galleries
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No galleries selected for deletion'
                ], 400);
            }

            $deleted = Gallery::bulkDeleteModel($ids);

            return response()->json([
                'success' => true,
                'message' => "{$deleted} gallery(s) have been deleted!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting galleries: ' . $e->getMessage()
            ], 500);
        }
    }
}
