<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jumbotron;
use RealRashid\SweetAlert\Facades\Alert;

class JumbotronController extends Controller
{
    /**
     * Display a listing of jumbotrons (Admin Index)
     */
    public function indexAdmin(Request $request)
    {
        $items = Jumbotron::searchAdminJumbotrons($request);
        $tableConfig = Jumbotron::getTableConfig();

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

        return view('admin-page.home.jumbotron.index', compact('items', 'tableConfig'))
            ->with('title', 'Home');
    }

    /**
     * Show the form for creating a new jumbotron
     */
    public function create()
    {
        return view('admin-page.home.jumbotron.create')
            ->with('title', 'Home');
    }

    /**
     * Store a newly created jumbotron
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'picture' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        try {
            Jumbotron::saveModel($request);
            Alert::success('Success', 'Jumbotron has been created!');
            return redirect()->route('admin.jumbotron.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to create jumbotron: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified jumbotron (Admin Preview)
     */
    public function showAdmin($id)
    {
        $jumbotron = Jumbotron::findOrFail($id);

        return view('admin-page.home.jumbotron.view', compact('jumbotron'))
            ->with('title', 'Home');
    }

    /**
     * Show the form for editing the specified jumbotron
     */
    public function edit($id)
    {
        $jumbotron = Jumbotron::findOrFail($id);

        return view('admin-page.home.jumbotron.update', compact('jumbotron'))
            ->with('title', 'Home');
    }

    /**
     * Update the specified jumbotron
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        try {
            $jumbotron = Jumbotron::findOrFail($id);
            $jumbotron->updateModel($request);
            Alert::success('Success', 'Jumbotron has been updated!');
            return redirect()->route('admin.jumbotron.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update jumbotron: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified jumbotron
     */
    public function destroy($id)
    {
        try {
            $jumbotron = Jumbotron::findOrFail($id);
            $jumbotron->deleteModel();

            return response()->json([
                'success' => true,
                'message' => 'Jumbotron has been deleted!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting jumbotron: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete jumbotrons
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No jumbotrons selected for deletion'
                ], 400);
            }

            $deleted = Jumbotron::bulkDeleteModel($ids);

            return response()->json([
                'success' => true,
                'message' => "{$deleted} jumbotron(s) have been deleted!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting jumbotrons: ' . $e->getMessage()
            ], 500);
        }
    }
}
