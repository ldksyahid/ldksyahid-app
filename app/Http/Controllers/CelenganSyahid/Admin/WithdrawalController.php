<?php

namespace App\Http\Controllers\CelenganSyahid\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CelsyahidAuditLog;
use App\Models\Withdrawal;
use App\Services\BisaTopup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class WithdrawalController extends Controller
{
    /* ================================================================
       BALANCE — AJAX: get real-time Bisabiller wallet balance
       ================================================================ */

    public function balance()
    {
        $balance = (new BisaTopup())->walletBalance();
        Cache::put('bisabiller_wallet_balance', $balance, 300);
        return response()->json(['balance' => $balance]);
    }

    /* ================================================================
       INDEX — list all withdrawals (global, all campaigns)
       ================================================================ */

    public function index(Request $request)
    {
        $query = Withdrawal::with('campaign', 'creator')->orderBy('created_at', 'desc');

        if ($request->filled('campaign_id')) {
            $query->where('campaign_id', $request->campaign_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $items = $query->paginate(20)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'tableHtml'      => view('admin-page.service.celengan-syahid.withdrawal.components._table', compact('items'))->render(),
                'paginationHtml' => $items->appends($request->query())->links()->render(),
                'total'          => $items->total(),
            ]);
        }

        $campaigns = Campaign::orderBy('judul')->pluck('judul', 'id');

        $bisabillerBalance = Cache::remember('bisabiller_wallet_balance', 300, function () {
            return (new BisaTopup())->walletBalance();
        });

        return view('admin-page.service.celengan-syahid.withdrawal.index', [
            'items'             => $items,
            'campaigns'         => $campaigns,
            'bisabillerBalance' => $bisabillerBalance,
            'title'             => 'Celengan Syahid',
        ]);
    }

    /* ================================================================
       CREATE — step 1: fill form
       ================================================================ */

    public function create(Request $request)
    {
        $campaigns = Campaign::orderBy('judul')->get(['id', 'judul']);
        $campaign  = $request->filled('campaign_id')
            ? Campaign::find($request->campaign_id)
            : null;

        $balance  = $campaign ? $campaign->getBalanceSummary() : null;

        $bankList = Cache::remember('bisabiller_bank_list', 3600, function () {
            return (new BisaTopup())->bankList();
        });

        return view('admin-page.service.celengan-syahid.withdrawal.create', [
            'campaigns' => $campaigns,
            'campaign'  => $campaign,
            'balance'   => $balance,
            'bankList'  => $bankList,
            'title'     => 'Celengan Syahid',
        ]);
    }

    /* ================================================================
       INQUIRY — AJAX: verify destination account
       ================================================================ */

    public function inquiry(Request $request)
    {
        $request->validate([
            'bank_code'      => 'required|string',
            'account_number' => 'required|string',
        ]);

        $result = (new BisaTopup())->inquiryBank(
            $request->bank_code,
            $request->account_number
        );

        if (!$result || !empty($result['error'])) {
            return response()->json([
                'error'   => true,
                'message' => 'Account not found or verification failed.',
            ], 422);
        }

        return response()->json([
            'error'          => false,
            'account_holder' => data_get($result, 'data.account_holder'),
            'fee'            => (int) data_get($result, 'data.fee', 0),
        ]);
    }

    /* ================================================================
       STORE — save draft, redirect to confirm
       ================================================================ */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'campaign_id'         => 'required|exists:campaigns,id',
            'bank_code'           => 'required|string|max:20',
            'account_number'      => 'required|string|max:30',
            'account_holder'      => 'required|string|max:100',
            'recipient_city_code' => 'nullable|string|max:10',
            'amount'              => 'required|integer|min:10000',
            'fee'                 => 'required|integer|min:0',
            'remark'              => 'nullable|string|max:100',
        ]);

        $campaign = Campaign::findOrFail($validated['campaign_id']);
        $balance  = $campaign->getBalanceSummary();

        if ((int) $validated['amount'] > $balance['available']) {
            return back()
                ->withErrors(['amount' => 'Amount exceeds available balance (Rp ' . number_format($balance['available'], 0, ',', '.') . ')'])
                ->withInput();
        }

        $withdrawal = Withdrawal::create([
            'campaign_id'         => $validated['campaign_id'],
            'created_by'          => auth()->id(),
            'reff_id'             => Withdrawal::generateReffId($validated['campaign_id']),
            'amount'              => $validated['amount'],
            'fee'                 => $validated['fee'],
            'bank_code'           => $validated['bank_code'],
            'account_number'      => $validated['account_number'],
            'account_holder'      => $validated['account_holder'],
            'recipient_city_code' => $validated['recipient_city_code'] ?? null,
            'remark'              => $validated['remark'],
            'status'              => 'DRAFT',
        ]);

        CelsyahidAuditLog::record(
            'withdrawal.draft', 'withdrawal', $withdrawal->id,
            'Draft withdrawal Rp ' . number_format($validated['amount'], 0, ',', '.') . ' for campaign: ' . $campaign->judul
        );

        return redirect()->route('admin.celsyahid.withdrawal.confirm', $withdrawal->id);
    }

    /* ================================================================
       CONFIRM — step 2: review before execute
       ================================================================ */

    public function confirm(string $id)
    {
        $withdrawal = Withdrawal::with('campaign')->findOrFail($id);

        if ($withdrawal->status !== 'DRAFT') {
            Alert::warning('Info', 'This withdrawal has already been processed.');
            return redirect()->route('admin.celsyahid.withdrawal.show', $id);
        }

        return view('admin-page.service.celengan-syahid.withdrawal.confirm', [
            'withdrawal' => $withdrawal,
            'title'      => 'Celengan Syahid',
        ]);
    }

    /* ================================================================
       EXECUTE — POST to Bisabiller disbursement API
       ================================================================ */

    public function execute(string $id)
    {
        $withdrawal = Withdrawal::with('campaign')->findOrFail($id);

        if ($withdrawal->status !== 'DRAFT') {
            Alert::warning('Info', 'This withdrawal has already been processed.');
            return redirect()->route('admin.celsyahid.withdrawal.show', $id);
        }

        $payload = [
            'bank_code'      => $withdrawal->bank_code,
            'account_number' => $withdrawal->account_number,
            'amount'         => $withdrawal->amount,
            'remark'         => $withdrawal->remark ?: ('Fund withdrawal - ' . $withdrawal->campaign->judul),
            'reff_id'        => $withdrawal->reff_id,
        ];
        if ($withdrawal->recipient_city_code) {
            $payload['recipient_city'] = $withdrawal->recipient_city_code;
        }

        $response = (new BisaTopup())->disburse($payload);

        if (!$response || !empty($response['error'])) {
            Log::error('[Withdrawal] disburse failed', [
                'withdrawal_id' => $withdrawal->id,
                'response'      => $response,
            ]);
            $withdrawal->update([
                'status'                => 'FAILED',
                'disbursement_response' => $response,
            ]);
            CelsyahidAuditLog::record('withdrawal.failed', 'withdrawal', $withdrawal->id, 'Disbursement rejected by Amdigipay - Bisatopup.');
            Alert::error('Failed', 'Withdrawal failed. Please try again or contact Bisabiller.');
            return redirect()->route('admin.celsyahid.withdrawal.index');
        }

        $withdrawal->update([
            'status'                => 'PENDING',
            'bisabiller_status_id'  => data_get($response, 'data.id_status'),
            'disbursement_response' => $response,
            'executed_at'           => now(),
        ]);

        Cache::forget('bisabiller_wallet_balance');

        CelsyahidAuditLog::record(
            'withdrawal.executed', 'withdrawal', $withdrawal->id,
            'Withdrawal Rp ' . number_format($withdrawal->amount, 0, ',', '.') . ' sent to Bisabiller. reff_id: ' . $withdrawal->reff_id
        );

        Alert::success('Success', 'Withdrawal submitted to Bisabiller. Awaiting confirmation.');
        return redirect()->route('admin.celsyahid.withdrawal.show', $withdrawal->id);
    }

    /* ================================================================
       SHOW — detail of one withdrawal
       ================================================================ */

    public function show(string $id)
    {
        $withdrawal = Withdrawal::with('campaign', 'creator')->findOrFail($id);

        return view('admin-page.service.celengan-syahid.withdrawal.show', [
            'withdrawal' => $withdrawal,
            'title'      => 'Celengan Syahid',
        ]);
    }

    /* ================================================================
       CALLBACK — webhook from Bisabiller for disbursement status
       POST /celengan-syahid/disbursement-callback (no auth, no CSRF)
       ================================================================ */

    public function callback(Request $request)
    {
        $payload = $request->all();
        Log::info('[Withdrawal Callback] received', ['payload' => $payload]);

        $reffId = $payload['reff_id'] ?? null;
        if (!$reffId) {
            return response()->json(['status' => 'ignored', 'reason' => 'no reff_id']);
        }

        $withdrawal = Withdrawal::where('reff_id', $reffId)->first();
        if (!$withdrawal) {
            Log::warning('[Withdrawal Callback] reff_id not found', ['reff_id' => $reffId]);
            return response()->json(['status' => 'ignored', 'reason' => 'not found']);
        }

        if (in_array($withdrawal->status, ['COMPLETED', 'FAILED'])) {
            Log::info('[Withdrawal Callback] already final', ['reff_id' => $reffId]);
            return response()->json(['status' => 'ok', 'message' => 'already final']);
        }

        $statusId  = (int) ($payload['status_id'] ?? 0);
        $newStatus = match (true) {
            in_array($statusId, [3, 4]) => 'COMPLETED',
            in_array($statusId, [5, 14]) => 'FAILED',
            default => 'PENDING',
        };

        $withdrawal->update([
            'status'               => $newStatus,
            'bisabiller_status_id' => $statusId,
            'receipt_url'          => $payload['receipt'] ?? null,
            'completed_at'         => $newStatus === 'COMPLETED' ? now() : null,
        ]);

        Cache::forget('bisabiller_wallet_balance');

        Log::info('[Withdrawal Callback] updated', [
            'reff_id'  => $reffId,
            'status'   => $newStatus,
            'status_id'=> $statusId,
        ]);

        return response()->json(['status' => 'ok']);
    }
}
