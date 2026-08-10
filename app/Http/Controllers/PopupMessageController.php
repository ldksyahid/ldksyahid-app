<?php

namespace App\Http\Controllers;

use App\Models\PopupMessage;
use Illuminate\Http\Request;

class PopupMessageController extends Controller
{
    public function index(Request $request)
    {
        $offset = max(0, (int) $request->query('offset', 0));

        $messages = PopupMessage::orderBy('createdDate', 'desc')
            ->skip($offset)
            ->take(5)
            ->get(['messageID', 'senderName', 'messageText', 'createdDate']);

        $total = PopupMessage::count();

        return response()->json([
            'messages' => $messages,
            'total'    => $total,
            'hasMore'  => ($offset + 5) < $total,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'senderName'  => 'required|string|max:80',
            'messageText' => 'required|string|max:300',
        ]);

        $message = PopupMessage::create($validated);
        $message->refresh();

        return response()->json([
            'message' => [
                'messageID'   => $message->messageID,
                'senderName'  => $message->senderName,
                'messageText' => $message->messageText,
                'createdDate' => $message->createdDate,
            ],
        ], 201);
    }
}
