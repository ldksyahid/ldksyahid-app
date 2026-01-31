<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReqShortlink;
use RealRashid\SweetAlert\Facades\Alert;

class RequestShortlinkController extends Controller
{
    /**
     * Landing page - Show create form
     */
    public function create()
    {
        return view('landing-page.service.short-link.index', ["title" => "Layanan"]);
    }

    /**
     * Landing page - Store request shortlink
     */
    public function store(Request $request)
    {
        ReqShortlink::create([
            "name" => $request->name,
            "email" => $request->email,
            "whatsapp" => $request->whatsapp,
            "defaultLink" => $request->defaultLink,
            "customLink" => $request->customLink,
            "note" => $request->note,
        ]);
        Alert::success('Permintaan Perpendek URL berhasil dikirim', 'Kami akan menghubungimu melalui Whatsapp yang telah di daftarkan setelah Shortlink berhasil kami buat')->autoClose(15000)->width('40%');
        return redirect('/shortlink');
    }

    /**
     * Admin - Display request shortlink list with AJAX support
     */
    public function indexAdmin(Request $request)
    {
        $items = ReqShortlink::searchAdminReqShortlinks($request);
        $tableConfig = ReqShortlink::getTableConfig();

        // Get select2 options
        $nameOptions = ReqShortlink::getNameOptions();
        $statusOptions = ReqShortlink::getStatusOptions();

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

        return view('admin-page.service-request.short-link.index', compact('items', 'tableConfig', 'nameOptions', 'statusOptions'))
            ->with('title', 'Request Shortlink');
    }

    /**
     * Admin - Show request shortlink detail (view mode)
     */
    public function showAdmin($id)
    {
        $reqshortlink = ReqShortlink::findOrFail($id);

        return view('admin-page.service-request.short-link.view', compact('reqshortlink'))
            ->with('title', 'Request Shortlink');
    }

    /**
     * Admin - Show edit form
     */
    public function edit($id)
    {
        $reqshortlink = ReqShortlink::findOrFail($id);

        return view('admin-page.service-request.short-link.update', compact('reqshortlink'))
            ->with('title', 'Request Shortlink');
    }

    /**
     * Admin - Update request shortlink
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:255',
            'defaultLink' => 'required|string|max:255',
            'customLink' => 'required|string|max:255',
            'note' => 'required|string',
            'fixCustomLink' => 'nullable|string|max:255',
        ]);

        try {
            $reqshortlink = ReqShortlink::findOrFail($id);
            $reqshortlink->updateModel($request);
            Alert::success('Success', 'Request Shortlink has been updated!');
            return redirect()->route('admin.reqservice.shortlink.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update Request Shortlink: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Admin - Delete request shortlink
     */
    public function destroy($id)
    {
        try {
            $reqshortlink = ReqShortlink::findOrFail($id);
            $reqshortlink->deleteModel();

            return response()->json([
                'success' => true,
                'message' => 'Request Shortlink has been deleted!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting Request Shortlink: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin - Bulk delete request shortlinks
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No request shortlinks selected for deletion'
                ], 400);
            }

            $deleted = ReqShortlink::bulkDeleteModel($ids);

            return response()->json([
                'success' => true,
                'message' => "{$deleted} request shortlink(s) have been deleted!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting request shortlinks: ' . $e->getMessage()
            ], 500);
        }
    }
}
