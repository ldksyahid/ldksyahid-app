<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Structure;
use RealRashid\SweetAlert\Facades\Alert;

class StructureController extends Controller
{
    /**
     * Landing page - Display all structures
     */
    public function index()
    {
        $poststructure = Structure::orderBy('created_at','desc')->get();
        return view('landing-page.about.management-structur', compact('poststructure'),["title" => "Tentang Kami"]);
    }

    /**
     * Admin - Display structure list with AJAX support
     */
    public function indexAdmin(Request $request)
    {
        $items = Structure::searchAdminStructures($request);
        $tableConfig = Structure::getTableConfig();

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

        return view('admin-page.about.management-structure.index', compact('items', 'tableConfig'))
            ->with('title', 'Structure Management');
    }

    /**
     * Admin - Show create form
     */
    public function create()
    {
        return view('admin-page.about.management-structure.create', ["title" => "Structure Management"]);
    }

    /**
     * Admin - Store new structure
     */
    public function store(Request $request)
    {
        $request->validate([
            'batch' => 'required|string|max:50',
            'period' => 'required|string|max:50',
            'structureName' => 'required|string|max:255',
            'structureDescription' => 'required|string',
            'structureLogo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'structureImage' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        try {
            Structure::saveModel($request);
            Alert::success('Success', 'Structure has been created!');
            return redirect()->route('admin.about.structure.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to create structure: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Admin - Show edit form
     */
    public function edit($id)
    {
        $structure = Structure::findOrFail($id);
        return view('admin-page.about.management-structure.update', compact('structure'), ["title" => "Structure Management"]);
    }

    /**
     * Admin - Show structure detail (view mode)
     */
    public function showAdmin($id)
    {
        $structure = Structure::findOrFail($id);
        return view('admin-page.about.management-structure.view', compact('structure'), ["title" => "Structure Management"]);
    }

    /**
     * Admin - Update structure
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'batch' => 'required|string|max:50',
            'period' => 'required|string|max:50',
            'structureName' => 'required|string|max:255',
            'structureDescription' => 'required|string',
            'structureLogo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'structureImage' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        try {
            $structure = Structure::findOrFail($id);
            $structure->updateModel($request);
            Alert::success('Success', 'Structure has been updated!');
            return redirect()->route('admin.about.structure.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update structure: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Admin - Delete structure
     */
    public function destroy($id)
    {
        try {
            $structure = Structure::findOrFail($id);
            $structure->deleteModel();

            return response()->json([
                'success' => true,
                'message' => 'Structure has been deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete structure: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin - Bulk delete structures
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No structures selected for deletion'
                ], 400);
            }

            $deleted = Structure::bulkDeleteModel($ids);

            return response()->json([
                'success' => true,
                'message' => "{$deleted} structures have been deleted!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting structures: ' . $e->getMessage()
            ], 500);
        }
    }
}
