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
        try {
            // Validate request
            $validated = $request->validate([
                'name' => 'required|min:3|max:100',
                'email' => 'required|email|max:255',
                'subject' => 'required|min:5|max:200',
                'message' => 'required|min:10|max:1000',
            ], [
                'name.required' => 'Nama wajib diisi!',
                'name.min' => 'Nama minimal 3 karakter!',
                'email.required' => 'Email wajib diisi!',
                'email.email' => 'Format email tidak valid!',
                'subject.required' => 'Subjek wajib diisi!',
                'subject.min' => 'Subjek minimal 5 karakter!',
                'message.required' => 'Pesan wajib diisi!',
                'message.min' => 'Pesan minimal 10 karakter!',
            ]);

            $messagecontact = MessageContact::create([
                "name" => $request->name,
                "email" => $request->email,
                "subject" => $request->subject,
                "message" => $request->message,
            ]);

            // Check if AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesan Kamu Berhasil Dikirim! Terimakasih, Kami akan Menindaklanjuti Pesan kamu secepatnya. 🎉'
                ]);
            }

            // Fallback for non-AJAX
            Alert::success('Pesan Kamu Berhasil Dikirim', 'Terimakasih, Kami akan Menindaklanjuti Pesan kamu secepatnya!')->autoClose(5000)->width('40%');
            return redirect()->back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors(),
                    'message' => 'Validasi gagal. Harap periksa kembali data Anda.'
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.'
                ], 500);
            }
            Alert::error('Error', 'Terjadi kesalahan saat mengirim pesan!');
            return redirect()->back();
        }
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
