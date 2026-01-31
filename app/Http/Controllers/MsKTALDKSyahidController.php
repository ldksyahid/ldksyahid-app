<?php

namespace App\Http\Controllers;

use App\Models\LkFaculty;
use App\Models\LkGeneration;
use App\Models\LkMajor;
use App\Models\MsKTALDKSyahid;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MsKTALDKSyahidController extends Controller
{
    /**
     * Landing page - Show KTA profile
     */
    public function show($link)
    {
        $ktaData = MsKTALDKSyahid::where('linkProfile', $link)->with(['getFaculty', 'getMajor', 'getGeneration'])->orderBy('created_at', 'desc')->first();
        return view('landing-page.kta-ldksyahid.index', compact('ktaData'), ["title" => "KTA"]);
    }

    /**
     * Admin - Display KTA list with AJAX support
     */
    public function indexAdmin(Request $request)
    {
        $items = MsKTALDKSyahid::searchAdminKTA($request);
        $tableConfig = MsKTALDKSyahid::getTableConfig();

        $generationOptions = MsKTALDKSyahid::getGenerationOptions();
        $facultyOptions = MsKTALDKSyahid::getFacultyOptions();

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

        return view('admin-page.kta-ldksyahid.index', compact('items', 'tableConfig', 'generationOptions', 'facultyOptions'))
            ->with('title', 'KTA');
    }

    /**
     * Admin - Show create form
     */
    public function create()
    {
        $facultyModel = LkFaculty::pluck('facultyName', 'id');
        $generationModel = LkGeneration::pluck('generationName', 'id');
        return view('admin-page.kta-ldksyahid.create', compact('facultyModel', 'generationModel'))
            ->with('title', 'KTA');
    }

    /**
     * Admin - Store new KTA
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'nim' => 'required|string|max:255',
            'faculty' => 'required|integer',
            'major' => 'required|integer',
            'generation' => 'required|integer',
            'memberNumber' => 'required|string|max:255',
            'linkProfile' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        try {
            MsKTALDKSyahid::saveModel($request);
            Alert::success('Success', 'KTA has been created!');
            return redirect()->route('admin.ktaldksyahid.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to create KTA: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Admin - Show KTA detail (view mode)
     */
    public function preview($id)
    {
        $ktaData = MsKTALDKSyahid::with('getFaculty', 'getMajor', 'getGeneration')->findOrFail($id);
        return view('admin-page.kta-ldksyahid.view', compact('ktaData'))
            ->with('title', 'KTA');
    }

    /**
     * Admin - Show edit form
     */
    public function edit($id)
    {
        $ktaData = MsKTALDKSyahid::with('getFaculty', 'getMajor', 'getGeneration')->findOrFail($id);
        $facultyModel = LkFaculty::pluck('facultyName', 'id');
        $generationModel = LkGeneration::pluck('generationName', 'id');
        return view('admin-page.kta-ldksyahid.update', compact('ktaData', 'facultyModel', 'generationModel'))
            ->with('title', 'KTA');
    }

    /**
     * Admin - Update KTA
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'fullName' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'nim' => 'required|string|max:255',
            'faculty' => 'required|integer',
            'major' => 'required|integer',
            'generation' => 'required|integer',
            'memberNumber' => 'required|string|max:255',
            'linkProfile' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        try {
            $ktaData = MsKTALDKSyahid::findOrFail($id);
            $ktaData->updateModel($request);
            Alert::success('Success', 'KTA has been updated!');
            return redirect()->route('admin.ktaldksyahid.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update KTA: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Admin - Delete KTA
     */
    public function destroy($id)
    {
        try {
            $ktaData = MsKTALDKSyahid::findOrFail($id);
            $ktaData->deleteModel();

            return response()->json([
                'success' => true,
                'message' => 'KTA has been deleted!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting KTA: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin - Bulk delete KTAs
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No KTA selected for deletion'
                ], 400);
            }

            $deleted = MsKTALDKSyahid::bulkDeleteModel($ids);

            return response()->json([
                'success' => true,
                'message' => "{$deleted} KTA(s) have been deleted!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting KTAs: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API - Get majors by faculty ID
     */
    public function getMajor(Request $request)
    {
        $majorModel = LkMajor::where('facultyID', $request->id)->pluck('majorName', 'id');
        return response()->json($majorModel);
    }
}
