<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessageContact;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class MessageContactController extends Controller
{
    /**
     * Landing page - Store contact message
     */
    public function store(Request $request)
    {
        $messagecontact = MessageContact::create([
            "name" => $request->name,
            "email" => $request->email,
            "subject" => $request->subject,
            "message" => $request->message,
        ]);
        Alert::success('Pesan Kamu Berhasil Dikirim', 'Terimakasih, Kami akan Menindak lanjuti Pesan kamu secepatnya!')->autoClose(5000)->width('40%');
        return redirect()->back();
    }

    /**
     * Admin - Display message list with AJAX support
     */
    public function indexAdmin(Request $request)
    {
        $items = MessageContact::searchAdminMessages($request);
        $tableConfig = MessageContact::getTableConfig();

        // Get select2 options
        $nameOptions = MessageContact::getNameOptions();
        $subjectOptions = MessageContact::getSubjectOptions();

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

        return view('admin-page.about.contact-us.index', compact('items', 'tableConfig', 'nameOptions', 'subjectOptions'))
            ->with('title', 'Contact Message');
    }

    /**
     * Admin - Show message detail (view mode)
     */
    public function showAdmin($id)
    {
        $data = MessageContact::findOrFail($id);

        return view('admin-page.about.contact-us.view', compact('data'))
            ->with('title', 'Contact Message');
    }

    /**
     * Admin - Delete message
     */
    public function destroy($id)
    {
        try {
            $message = MessageContact::findOrFail($id);
            $message->deleteModel();

            return response()->json([
                'success' => true,
                'message' => 'Message has been deleted!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting message: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin - Bulk delete messages
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No messages selected for deletion'
                ], 400);
            }

            $deleted = MessageContact::bulkDeleteModel($ids);

            return response()->json([
                'success' => true,
                'message' => "{$deleted} message(s) have been deleted!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting messages: ' . $e->getMessage()
            ], 500);
        }
    }
}
