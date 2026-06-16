<?php

namespace App\Http\Controllers\CelenganSyahid\Admin;

use App\Helpers\TwoFaHelper;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CelsyahidAuditLog;
use App\Models\Donation;
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

        // Do not persist an empty list — a failed API call should not block future attempts.
        $bankList = Cache::get('bisabiller_bank_list', []);
        if (empty($bankList)) {
            $bankList = (new BisaTopup())->bankList();
            if (!empty($bankList)) {
                Cache::put('bisabiller_bank_list', $bankList, 3600);
            }
        }

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

    public function execute(Request $request, string $id)
    {
        $withdrawal = Withdrawal::with('campaign')->findOrFail($id);

        if ($withdrawal->status !== 'DRAFT') {
            Alert::warning('Info', 'This withdrawal has already been processed.');
            return redirect()->route('admin.celsyahid.withdrawal.show', $id);
        }

        // 2FA check — only for whitelisted users
        $user = auth()->user();
        if (TwoFaHelper::isAllowed($user)) {
            if (!$user->google2fa_enabled) {
                Alert::warning('2FA Required', 'Please enable Two-Factor Authentication before executing withdrawals.');
                return redirect()->route('admin.security.2fa');
            }

            $code = $request->input('two_fa_code', '');
            if (!TwoFaHelper::verify($user, $code)) {
                CelsyahidAuditLog::record('2fa.verify_failed', 'withdrawal', $withdrawal->id, '2FA failed during execute from IP: ' . $request->ip());
                Alert::error('Invalid Code', 'The authenticator code is incorrect or expired. Please try again.');
                return redirect()->route('admin.celsyahid.withdrawal.confirm', $id);
            }

            CelsyahidAuditLog::record('2fa.verify_success', 'withdrawal', $withdrawal->id, '2FA verified for withdrawal execute from IP: ' . $request->ip());
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
       BALANCE REPORT — discrepancy between Bisabiller wallet and DB
       ================================================================ */

    public function balanceReport()
    {
        // Total QRIS PAID per campaign
        $perCampaign = Donation::where('gateway', 'bisatopup')
            ->where('payment_status', 'PAID')
            ->selectRaw('campaign_id, SUM(jumlah_donasi) as total_qris, SUM(biaya_admin) as total_fee, COUNT(*) as txn_count')
            ->groupBy('campaign_id')
            ->with('campaign:id,judul')
            ->get();

        // Total withdrawn per campaign (COMPLETED)
        $withdrawnPerCampaign = Withdrawal::where('status', 'COMPLETED')
            ->selectRaw('campaign_id, SUM(amount) as total_withdrawn')
            ->groupBy('campaign_id')
            ->pluck('total_withdrawn', 'campaign_id');

        $rows = $perCampaign->map(function ($row) use ($withdrawnPerCampaign) {
            $withdrawn = $withdrawnPerCampaign[$row->campaign_id] ?? 0;
            return [
                'campaign'        => $row->campaign->judul ?? '—',
                'total_qris'      => (int) $row->total_qris,
                'total_fee'       => (int) $row->total_fee,
                'total_withdrawn' => (int) $withdrawn,
                'net'             => (int) $row->total_qris - (int) $row->total_fee - (int) $withdrawn,
                'txn_count'       => (int) $row->txn_count,
            ];
        });

        $totalExpected = $rows->sum('net');

        $actualBalance = Cache::remember('bisabiller_wallet_balance', 300, function () {
            return (new BisaTopup())->walletBalance();
        });

        $discrepancy = ($actualBalance !== null) ? ($actualBalance - $totalExpected) : null;
        $threshold   = config('services.two_fa.discrepancy_threshold', 50000);
        $isNormal    = ($discrepancy !== null) && abs($discrepancy) <= $threshold;

        return view('admin-page.service.celengan-syahid.withdrawal.balance-report', [
            'rows'          => $rows,
            'totalExpected' => $totalExpected,
            'actualBalance' => $actualBalance,
            'discrepancy'   => $discrepancy,
            'isNormal'      => $isNormal,
            'threshold'     => $threshold,
            'title'         => 'Celengan Syahid',
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
