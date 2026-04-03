<?php

namespace App\Http\Controllers;

use App\Mail\SubscribeConfirmation;
use App\Mail\UnsubscribeConfirmation;
use App\Models\TrSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{
    /**
     * Subscribe newsletter
     */
    public function store(Request $request)
    {
        $result = TrSubscription::subscribe($request);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'errors' => $result['errors']
            ], $result['status'] ?? 422);
        }

        // Kirim email konfirmasi subscribe
        try {
            Mail::to($request->email)->send(new SubscribeConfirmation($request->email));
        } catch (\Throwable $e) {
            Log::error('[SubscriptionController] Gagal kirim email subscribe', [
                'email' => $request->email,
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $result['message']
        ]);
    }

    /**
     * Unsubscribe newsletter
     */
    public function unsubscribe(Request $request)
    {
        $result = TrSubscription::unsubscribe($request);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'errors' => $result['errors']
            ], $result['status'] ?? 422);
        }

        // Kirim email konfirmasi unsubscribe
        try {
            Mail::to($request->email)->send(new UnsubscribeConfirmation($request->email));
        } catch (\Throwable $e) {
            Log::error('[SubscriptionController] Gagal kirim email unsubscribe', [
                'email' => $request->email,
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $result['message']
        ]);
    }
}
