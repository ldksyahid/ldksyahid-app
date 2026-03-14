<?php

namespace App\Http\Controllers;

use App\Models\ITSupport;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ITSupportController extends Controller
{
    /**
     * Landing page - Display all IT Supports
     */
    public function index()
    {
        $postitsupport = ITSupport::orderBy('created_at', 'desc')->get();
        return view('landing-page.it-support.index', compact('postitsupport'), ["title" => "Tim Teknologi"]);
    }

    /**
     * Admin - Display IT Support list with AJAX support
     */
    public function indexAdmin(Request $request)
    {
        $items = ITSupport::searchAdminITSupports($request);
        $tableConfig = ITSupport::getTableConfig();

        // Get select2 options
        $forkatOptions = ITSupport::getForkatOptions();
        $positionOptions = ITSupport::getPositionOptions();

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

        return view('admin-page.about.it-support.index', compact('items', 'tableConfig', 'forkatOptions', 'positionOptions'))
            ->with('title', 'IT Support');
    }

    /**
     * Admin - Show create form
     */
    public function create()
    {
        return view('admin-page.about.it-support.create')
            ->with('title', 'IT Support');
    }

    /**
     * Admin - Store new IT Support
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'forkat' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photoProfile' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'linkInstagram' => 'required|string|max:255',
            'linkLinkedin' => 'required|string|max:255',
        ]);

        try {
            ITSupport::saveModel($request);
            Alert::success('Success', 'IT Support has been created!');
            return redirect()->route('admin.about.itsupport.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to create IT Support: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Admin - Show edit form
     */
    public function edit($id)
    {
        $itsupport = ITSupport::findOrFail($id);

        return view('admin-page.about.it-support.update', compact('itsupport'))
            ->with('title', 'IT Support');
    }

    /**
     * Admin - Show IT Support detail (view mode)
     */
    public function showAdmin($id)
    {
        $itsupport = ITSupport::findOrFail($id);

        return view('admin-page.about.it-support.view', compact('itsupport'))
            ->with('title', 'IT Support');
    }

    /**
     * Admin - Update IT Support
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'forkat' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photoProfile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'linkInstagram' => 'required|string|max:255',
            'linkLinkedin' => 'required|string|max:255',
        ]);

        try {
            $itsupport = ITSupport::findOrFail($id);
            $itsupport->updateModel($request);
            Alert::success('Success', 'IT Support has been updated!');
            return redirect()->route('admin.about.itsupport.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update IT Support: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Admin - Delete IT Support
     */
    public function destroy($id)
    {
        try {
            $itsupport = ITSupport::findOrFail($id);
            $itsupport->deleteModel();

            return response()->json([
                'success' => true,
                'message' => 'IT Support has been deleted!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting IT Support: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin - Bulk delete IT Supports
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No IT Support selected for deletion'
                ], 400);
            }

            $deleted = ITSupport::bulkDeleteModel($ids);

            return response()->json([
                'success' => true,
                'message' => "{$deleted} IT Support(s) have been deleted!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting IT Supports: ' . $e->getMessage()
            ], 500);
        }
    }
}
