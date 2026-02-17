<?php

namespace App\Http\Controllers;

use App\Models\TrSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    /**
     * Store a newly created subscription in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:tr_subscription,email',
        ], [
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Format email tidak valid!',
            'email.unique' => 'Email ini sudah terdaftar di newsletter kami!',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('newsletter_error', $validator->errors()->first());
        }

        try {
            // Create new subscription
            TrSubscription::create([
                'email' => $request->email,
                'status' => 'active',
                'subscribedDate' => now(),
            ]);

            return redirect()->back()->with('newsletter_success', 'Terima kasih! Email kamu berhasil didaftarkan. 🎉');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('newsletter_error', 'Terjadi kesalahan. Silakan coba lagi nanti.');
        }
    }

    /**
     * Unsubscribe an email from newsletter
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:tr_subscription,email',
        ], [
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Format email tidak valid!',
            'email.exists' => 'Email tidak ditemukan dalam daftar newsletter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('newsletter_error', $validator->errors()->first());
        }

        try {
            $subscription = TrSubscription::where('email', $request->email)->first();

            if ($subscription) {
                $subscription->update([
                    'status' => 'inactive',
                    'unsubscribedDate' => now(),
                ]);

                return redirect()->back()->with('newsletter_success', 'Email kamu berhasil dihapus dari newsletter.');
            }

            return redirect()->back()->with('newsletter_error', 'Email tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('newsletter_error', 'Terjadi kesalahan. Silakan coba lagi nanti.');
        }
    }
}
