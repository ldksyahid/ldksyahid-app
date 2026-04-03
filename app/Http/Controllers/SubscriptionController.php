<?php

namespace App\Http\Controllers;

use App\Mail\SubscribeConfirmation;
use App\Mail\UnsubscribeConfirmation;
use App\Models\TrSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class SubscriptionController extends Controller
{
    /* =========================================================================
       SECTION A — LANDING PAGE (Public)
       ========================================================================= */

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

        // Send subscribe confirmation email
        try {
            Mail::to($request->email)->send(new SubscribeConfirmation($request->email));
        } catch (\Throwable $e) {
            Log::error('[SubscriptionController] Failed to send subscribe email', [
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
     * Unsubscribe confirmation page (GET — from email link)
     */
    public function unsubscribePage(Request $request)
    {
        $email = $request->query('email', '');
        return view('landing-page.subscription.unsubscribe', compact('email'))
            ->with('title', 'Unsubscribe');
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

        // Send unsubscribe confirmation email
        try {
            Mail::to($request->email)->send(new UnsubscribeConfirmation($request->email));
        } catch (\Throwable $e) {
            Log::error('[SubscriptionController] Failed to send unsubscribe email', [
                'email' => $request->email,
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $result['message']
        ]);
    }

    /* =========================================================================
       SECTION B — ADMIN AREA
       ========================================================================= */

    public function indexAdmin(Request $request)
    {
        $items       = TrSubscription::searchAdmin($request);
        $tableConfig = TrSubscription::getTableConfig();

        if ($request->ajax()) {
            return response()->json([
                'tableBody'  => view('components.admin-index.index-table', compact('items', 'tableConfig'))->render(),
                'pagination' => $items->appends($request->query())->links()->render(),
                'total'      => $items->total(),
                'from'       => $items->firstItem(),
                'to'         => $items->lastItem(),
            ]);
        }

        return view('admin-page.subscription.index', compact('items', 'tableConfig'))
            ->with('title', 'Subscription');
    }

    public function create()
    {
        return view('admin-page.subscription.create')->with('title', 'Add Subscribers');
    }

    public function adminStore(Request $request)
    {
        $request->validate(['emails' => 'required|string']);

        $result = TrSubscription::addMultiple($request->emails);

        if ($result['added'] === 0 && !empty($result['invalid'])) {
            Alert::error('Error', 'No valid email format found.');
            return redirect()->back()->withInput();
        }

        $msg = "{$result['added']} email(s) added successfully.";
        if (!empty($result['skipped'])) $msg .= ' ' . count($result['skipped']) . ' already active (skipped).';
        if (!empty($result['invalid'])) $msg .= ' ' . count($result['invalid']) . ' invalid format (skipped).';

        Alert::success('Done', $msg);
        return redirect()->route('admin.subscription.index');
    }

    public function showAdmin($id)
    {
        $subscription = TrSubscription::findOrFail($id);
        return view('admin-page.subscription.form', [
            'subscription' => $subscription,
            'operation'    => 'view',
        ])->with('title', 'View Subscriber');
    }

    public function edit($id)
    {
        $subscription = TrSubscription::findOrFail($id);
        return view('admin-page.subscription.form', [
            'subscription' => $subscription,
            'operation'    => 'edit',
        ])->with('title', 'Edit Subscriber');
    }

    public function update(Request $request, $id)
    {
        $subscription = TrSubscription::findOrFail($id);

        $request->validate([
            'email'      => 'required|email|max:255|unique:tr_subscription,email,' . $id . ',subscriberID',
            'flagActive' => 'required|boolean',
        ], [
            'email.unique' => 'This email is already used by another subscriber.',
        ]);

        $subscription->updateAdmin($request->email, $request->boolean('flagActive'));

        Alert::success('Success', 'Subscriber updated successfully.');
        return redirect()->route('admin.subscription.index');
    }

    public function destroy($id)
    {
        try {
            TrSubscription::findOrFail($id)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        TrSubscription::whereIn('subscriberID', $request->ids)->delete();
        return response()->json(['success' => true]);
    }
}
