<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimony;
use RealRashid\SweetAlert\Facades\Alert;

class TestimonyController extends Controller
{
    /**
     * Display a listing of testimonies (Admin Index)
     */
    public function indexAdmin(Request $request)
    {
        $items = Testimony::searchAdminTestimonies($request);
        $tableConfig = Testimony::getTableConfig();

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

        return view('admin-page.home.testimony.index', compact('items', 'tableConfig'))
            ->with('title', 'Home');
    }

    /**
     * Show the form for creating a new testimony
     */
    public function create()
    {
        return view('admin-page.home.testimony.create')
            ->with('title', 'Home');
    }

    /**
     * Store a newly created testimony
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'testimony' => 'required|string|max:250',
            'picture' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        try {
            Testimony::saveModel($request);
            Alert::success('Success', 'Testimony has been created!');
            return redirect()->route('admin.testimony.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to create testimony: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified testimony (Admin Preview)
     */
    public function showAdmin($id)
    {
        $testimony = Testimony::findOrFail($id);

        return view('admin-page.home.testimony.view', compact('testimony'))
            ->with('title', 'Home');
    }

    /**
     * Show the form for editing the specified testimony
     */
    public function edit($id)
    {
        $testimony = Testimony::findOrFail($id);

        return view('admin-page.home.testimony.update', compact('testimony'))
            ->with('title', 'Home');
    }

    /**
     * Update the specified testimony
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'testimony' => 'required|string|max:250',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        try {
            $testimony = Testimony::findOrFail($id);
            $testimony->updateModel($request);
            Alert::success('Success', 'Testimony has been updated!');
            return redirect()->route('admin.testimony.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update testimony: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified testimony
     */
    public function destroy($id)
    {
        try {
            $testimony = Testimony::findOrFail($id);
            $testimony->deleteModel();

            return response()->json([
                'success' => true,
                'message' => 'Testimony has been deleted!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting testimony: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete testimonies
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No testimonies selected for deletion'
                ], 400);
            }

            $deleted = Testimony::bulkDeleteModel($ids);

            return response()->json([
                'success' => true,
                'message' => "{$deleted} testimony(ies) have been deleted!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting testimonies: ' . $e->getMessage()
            ], 500);
        }
    }
}
