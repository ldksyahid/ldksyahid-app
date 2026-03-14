<?php

namespace App\Http\Controllers;

use App\Models\TrSubscription;
use Illuminate\Http\Request;

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

        return response()->json([
            'success' => true,
            'message' => $result['message']
        ]);
    }
}
