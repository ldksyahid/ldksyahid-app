<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CallKestari;
use RealRashid\SweetAlert\Facades\Alert;

class CallKestariController extends Controller
{
    /* =========================================================================
       SECTION A — LANDING PAGE (Public)
       ========================================================================= */

    public function index(Request $request)
    {
        $query = CallKestari::where('appear', 'Up');

        if ($request->filled('search')) {
            $query->where('buttonName', 'like', '%' . $request->search . '%');
        }

        $sort = $request->input('sort', 'newest');
        if ($sort === 'az') {
            $query->orderBy('buttonName', 'asc');
        } elseif ($sort === 'za') {
            $query->orderBy('buttonName', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $data = $query->paginate(9)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'cards'      => view('landing-page.service.call-kestari.components._ck-cards', compact('data'))->render(),
                'pagination' => $data->hasPages()
                    ? view('components.pagination-custom.index', ['paginator' => $data, 'itemLabel' => 'tautan'])->render()
                    : '',
                'total' => $data->total(),
                'from'  => $data->firstItem() ?? 0,
                'to'    => $data->lastItem()  ?? 0,
            ]);
        }

        return view('landing-page.service.call-kestari.index', compact('data'), ["title" => "Layanan"]);
    }

    /* =========================================================================
       SECTION B — ADMIN AREA (with RESTful routing)
       ========================================================================= */

    public function indexAdmin(Request $request)
    {
        $callKestaris = CallKestari::searchAdminCallKestari($request);
        $appearOptions = CallKestari::getAppearOptions();
        $tableConfig = CallKestari::getTableConfig();

        if ($request->ajax()) {
            return response()->json([
                'tableBody' => view('components.admin-index.index-table', [
                    'items' => $callKestaris,
                    'tableConfig' => $tableConfig,
                ])->render(),
                'pagination' => $callKestaris->appends($request->query())->links()->render(),
                'total' => $callKestaris->total(),
                'from' => $callKestaris->firstItem(),
                'to' => $callKestaris->lastItem()
            ]);
        }

        return view('admin-page.service.call-kestari.index', compact('callKestaris', 'appearOptions', 'tableConfig'))
            ->with('title', 'Call Kestari');
    }

    public function create()
    {
        return view('admin-page.service.call-kestari.create')
            ->with('title', 'Create Call Kestari');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = CallKestari::validateRequest($request);
            CallKestari::saveModel($request);

            return redirect()->route('admin.service.callkestari.index')
                ->with('success', 'Call Kestari has been created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('failed', true)
                ->withErrors(['error' => 'Error creating call kestari: ' . $e->getMessage()]);
        }
    }

    public function showAdmin($id)
    {
        $callKestari = CallKestari::findOrFail($id);
        return view('admin-page.service.call-kestari.view', compact('callKestari'))
            ->with('title', 'View Call Kestari');
    }

    public function edit($id)
    {
        $callKestari = CallKestari::findOrFail($id);
        return view('admin-page.service.call-kestari.update', compact('callKestari'))
            ->with('title', 'Edit Call Kestari');
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = CallKestari::validateRequest($request);
            $callKestari = CallKestari::findOrFail($id);
            $callKestari->updateModel($request);

            return redirect()->route('admin.service.callkestari.index')
                ->with('success', 'Call Kestari has been updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('failed', true)
                ->withErrors(['error' => 'Error updating call kestari: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $callKestari = CallKestari::findOrFail($id);
            $callKestari->deleteModel();

            return response()->json([
                'success' => true,
                'message' => 'Call Kestari has been deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting call kestari: ' . $e->getMessage()
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
                    'message' => 'No call kestari selected for deletion'
                ], 400);
            }

            CallKestari::bulkDeleteModel($ids);

            return response()->json([
                'success' => true,
                'message' => 'Selected call kestari have been deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting call kestari: ' . $e->getMessage()
            ], 500);
        }
    }
}
