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
    /* ----------------------------------------------------------------
       Shared guard: only TWO_FA_ALLOWED_USERS with 2FA enabled may
       create / confirm / execute withdrawals.
       ---------------------------------------------------------------- */
    private function requireWithdrawalAccess(bool $isAjax = false)
    {
        $user = auth()->user();

        if (!TwoFaHelper::isAllowed($user)) {
            if ($isAjax) {
                return response()->json(['error' => true, 'message' => 'Access denied. You are not authorized to process withdrawals.'], 403);
            }
            Alert::error('Access Denied', 'You are not authorized to process withdrawals.');
            return redirect()->route('admin.celsyahid.withdrawal.index');
        }

        if (!$user->google2fa_enabled) {
            if ($isAjax) {
                return response()->json(['error' => true, 'message' => '2FA is required to process withdrawals. Please enable it first.'], 403);
            }
            Alert::warning('2FA Required', 'You must enable Two-Factor Authentication before processing withdrawals.');
            return redirect()->route('admin.security.2fa');
        }

        return null;
    }

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
                'tableHtml'    => view('admin-page.service.celengan-syahid.withdrawal.components._table', compact('items'))->render(),
                'total'        => $items->total(),
                'from'         => $items->firstItem() ?? 0,
                'to'           => $items->lastItem() ?? 0,
                'current_page' => $items->currentPage(),
                'last_page'    => $items->lastPage(),
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
        if ($deny = $this->requireWithdrawalAccess()) return $deny;

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
        if ($deny = $this->requireWithdrawalAccess(true)) return $deny;

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
                'error'          => true,
                'message'        => data_get($result, 'message', 'Account not found or verification failed.'),
                'status'         => data_get($result, 'data.status'),
                'bank_name'      => data_get($result, 'data.name'),
                'account_number' => data_get($result, 'data.account_number'),
            ], 422);
        }

        return response()->json([
            'error'          => false,
            'account_holder' => data_get($result, 'data.account_holder'),
            'account_number' => data_get($result, 'data.account_number'),
            'bank_name'      => data_get($result, 'data.name'),
            'status'         => data_get($result, 'data.status'),
            'fee'            => (int) data_get($result, 'data.fee', 0),
        ]);
    }

    /* ================================================================
       STORE — save draft, redirect to confirm
       ================================================================ */

    public function store(Request $request)
    {
        if ($deny = $this->requireWithdrawalAccess()) return $deny;

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
                ->withErrors(['amount' => 'Amount exceeds available balance (Rp ' . number_format($balance['available'], 0, ',', '.') . ').'])
                ->withInput();
        }

        $net = (int) $validated['amount'] - (int) $validated['fee'];
        if ($net <= 0) {
            return back()
                ->withErrors(['amount' => 'Amount must be greater than the transfer fee (Rp ' . number_format($validated['fee'], 0, ',', '.') . ').'])
                ->withInput();
        }
        if ($net < 10000) {
            return back()
                ->withErrors(['amount' => 'Recipient amount (Rp ' . number_format($net, 0, ',', '.') . ') is below the minimum transfer of Rp 10.000.'])
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
        if ($deny = $this->requireWithdrawalAccess()) return $deny;

        $withdrawal = Withdrawal::with('campaign')->findOrFail($id);

        if ($withdrawal->status !== 'DRAFT') {
            Alert::warning('Info', 'This withdrawal has already been processed.');
            return redirect()->route('admin.celsyahid.withdrawal.show', $id);
        }

        // Compute effective available balance at confirm time.
        // Uses qrisPaid − COMPLETED − other PENDING (not DRAFT, not the current one).
        // This lets the confirm page warn the admin if balance has changed since the draft was created.
        $balance         = $withdrawal->campaign->getBalanceSummary();
        $otherPending    = Withdrawal::where('campaign_id', $withdrawal->campaign_id)
            ->where('status', 'PENDING')
            ->where('id', '!=', $withdrawal->id)
            ->sum('amount');
        $effectiveAvailable = $balance['qris_paid'] - $balance['total_withdrawn'] - $otherPending;
        $canProceed         = $withdrawal->amount <= $effectiveAvailable;

        return view('admin-page.service.celengan-syahid.withdrawal.confirm', [
            'withdrawal'         => $withdrawal,
            'balance'            => $balance,
            'effectiveAvailable' => (int) $effectiveAvailable,
            'canProceed'         => $canProceed,
            'title'              => 'Celengan Syahid',
        ]);
    }

    /* ================================================================
       EXECUTE — POST to Bisabiller disbursement API
       ================================================================ */

    public function execute(Request $request, string $id)
    {
        if ($deny = $this->requireWithdrawalAccess()) return $deny;

        $withdrawal = Withdrawal::with('campaign')->findOrFail($id);

        if ($withdrawal->status !== 'DRAFT') {
            Alert::warning('Info', 'This withdrawal has already been processed.');
            return redirect()->route('admin.celsyahid.withdrawal.show', $id);
        }

        // 2FA verification — always required (requireWithdrawalAccess already ensures enabled)
        $user = auth()->user();
        $code = $request->input('two_fa_code', '');
        if (!TwoFaHelper::verify($user, $code)) {
            CelsyahidAuditLog::record('2fa.verify_failed', 'withdrawal', $withdrawal->id, '2FA failed during execute from IP: ' . $request->ip());
            Alert::error('Invalid Code', 'The authenticator code is incorrect or expired. Please try again.');
            return redirect()->route('admin.celsyahid.withdrawal.confirm', $id);
        }

        CelsyahidAuditLog::record('2fa.verify_success', 'withdrawal', $withdrawal->id, '2FA verified for withdrawal execute from IP: ' . $request->ip());

        // ── Atomic race-condition guard ─────────────────────────────────
        // Flip DRAFT → PENDING in a single WHERE+UPDATE. Only ONE concurrent
        // request can win this (DB guarantees atomicity). The loser gets 0
        // rows affected and is redirected before calling the external API.
        // This prevents two admins from simultaneously executing the same
        // or sibling DRAFT withdrawals against the same campaign balance.
        $flipped = \Illuminate\Support\Facades\DB::table('withdrawals')
            ->where('id', $id)
            ->where('status', 'DRAFT')
            ->update(['status' => 'PENDING']);

        if (!$flipped) {
            Alert::warning('Already Processing', 'This withdrawal is being processed by another request. Please wait and refresh.');
            return redirect()->route('admin.celsyahid.withdrawal.show', $id);
        }

        // Re-fetch after flip so the model reflects the new status.
        $withdrawal = $withdrawal->fresh('campaign');

        // ── Balance guard — runs AFTER our atomic flip ─────────────────
        // Since we are now PENDING, getBalanceSummary()['available'] already
        // deducts us. We compute effectiveAvail as: qrisPaid − COMPLETED −
        // OTHER pending (excluding ourselves) to get "available before us".
        // If another concurrent withdrawal already consumed the funds, this
        // will detect it and roll us back to DRAFT before touching the API.
        $balanceNow     = $withdrawal->campaign->getBalanceSummary();
        $otherPending   = Withdrawal::where('campaign_id', $withdrawal->campaign_id)
            ->where('status', 'PENDING')
            ->where('id', '!=', $withdrawal->id)
            ->sum('amount');
        $effectiveAvail = $balanceNow['qris_paid'] - $balanceNow['total_withdrawn'] - $otherPending;

        if ($withdrawal->amount > $effectiveAvail) {
            // Rollback: restore to DRAFT so admin can review.
            \Illuminate\Support\Facades\DB::table('withdrawals')
                ->where('id', $id)
                ->update(['status' => 'DRAFT']);

            Log::warning('[Withdrawal] execute rolled back — insufficient balance', [
                'withdrawal_id'       => $withdrawal->id,
                'amount'              => $withdrawal->amount,
                'effective_available' => $effectiveAvail,
            ]);
            CelsyahidAuditLog::record(
                'withdrawal.balance_check_failed', 'withdrawal', $withdrawal->id,
                'Execute rolled back: amount Rp ' . number_format($withdrawal->amount, 0, ',', '.') .
                ' exceeds effective available Rp ' . number_format($effectiveAvail, 0, ',', '.')
            );
            Alert::error(
                'Insufficient Balance',
                'Available balance is Rp ' . number_format($effectiveAvail, 0, ',', '.') .
                ', but this withdrawal requires Rp ' . number_format($withdrawal->amount, 0, ',', '.') .
                '. Another withdrawal may have already used these funds.'
            );
            return redirect()->route('admin.celsyahid.withdrawal.confirm', $id);
        }
        // ────────────────────────────────────────────────────────────────

        // Bisabiller API: `amount` = what the recipient receives.
        // Fee is charged additionally from the wallet (total_amount = amount + fee).
        // We send amount_net (gross - fee) so the wallet deduction equals the
        // `amount` the admin entered (gross), keeping campaign balance accounting correct.
        $payload = [
            'bank_code'      => $withdrawal->bank_code,
            'account_number' => $withdrawal->account_number,
            'amount'         => $withdrawal->amount_net,
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

        // Use actual fee from disburse response — may differ from inquiry fee.
        $actualFee = (int) data_get($response, 'data.fee', $withdrawal->fee);

        $withdrawal->update([
            'status'                => 'PENDING',
            'bisabiller_status_id'  => data_get($response, 'data.id_status'),
            'fee'                   => $actualFee,
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
       CHECK STATUS — AJAX polling for real-time status on show page
       ================================================================ */

    public function checkStatus(string $id)
    {
        $w = Withdrawal::findOrFail($id);

        return response()->json([
            'status'       => $w->status,
            'executed_at'  => optional($w->executed_at)->isoFormat('D MMM YYYY, HH:mm'),
            'completed_at' => optional($w->completed_at)->isoFormat('D MMM YYYY, HH:mm'),
            'receipt_url'  => $w->receipt_url,
        ]);
    }

    /* ================================================================
       BALANCE REPORT — discrepancy between Bisabiller wallet and DB
       ================================================================ */

    public function balanceReport(\Illuminate\Http\Request $request)
    {
        // Bisabiller charges 1% MDR (QRIS) per transaction, rounded UP per-transaction.
        $mdrRate           = (float) config('services.bisatopup.qris_mdr_percent', 1) / 100;
        $settlementMinutes = (int) config('services.bisatopup.settlement_minutes', 15);
        $cutoff            = now()->subMinutes($settlementMinutes);

        $rawSelect = 'campaign_id,
            SUM(COALESCE(total_tagihan, jumlah_donasi + biaya_admin)) as total_qris,
            COUNT(*) as txn_count,
            SUM(COALESCE(total_tagihan, jumlah_donasi + biaya_admin) - CEIL(COALESCE(total_tagihan, jumlah_donasi + biaya_admin) * ?)) as wallet_credit';

        // ALL paid bisatopup donations
        $allPaidByCampaign = Donation::where('gateway', 'bisatopup')
            ->where('payment_status', 'PAID')
            ->selectRaw($rawSelect, [$mdrRate])
            ->groupBy('campaign_id')
            ->with('campaign:id,judul')
            ->get()
            ->keyBy('campaign_id');

        // RECENT payments (within settlement window) — QRIS in-transit candidates
        $recentByCampaign = Donation::where('gateway', 'bisatopup')
            ->where('payment_status', 'PAID')
            ->where('updated_at', '>=', $cutoff)
            ->selectRaw($rawSelect, [$mdrRate])
            ->groupBy('campaign_id')
            ->with('campaign:id,judul')
            ->get()
            ->keyBy('campaign_id');

        // COMPLETED withdrawals per campaign (confirmed by callback)
        $completedByCampaign = Withdrawal::where('status', 'COMPLETED')
            ->selectRaw('campaign_id, SUM(amount) as total')
            ->groupBy('campaign_id')
            ->pluck('total', 'campaign_id');

        // PENDING withdrawals per campaign — sent to Bisabiller, wallet ALREADY deducted,
        // awaiting COMPLETED/FAILED callback. Must be included in expected balance.
        $pendingWdByCampaign = Withdrawal::where('status', 'PENDING')
            ->selectRaw('campaign_id, SUM(amount) as total, COUNT(*) as cnt')
            ->groupBy('campaign_id')
            ->get()
            ->keyBy('campaign_id');

        $recentPaidTotal      = (int) $recentByCampaign->sum('wallet_credit');
        $recentCountTotal     = (int) $recentByCampaign->sum('txn_count');
        $pendingTransferTotal = (int) $pendingWdByCampaign->sum('total');
        $pendingTransferCount = (int) $pendingWdByCampaign->sum('cnt');

        // expectedAll: total wallet credit minus everything already sent out of wallet.
        // PENDING withdrawals have already been deducted by Bisabiller, so they count here.
        $totalExpectedAll = (int) $allPaidByCampaign->sum('wallet_credit')
                          - (int) $completedByCampaign->sum()
                          - $pendingTransferTotal;

        $recentPaidTotal  = (int) $recentByCampaign->sum('wallet_credit');
        $recentCountTotal = (int) $recentByCampaign->sum('txn_count');

        $actualBalance = Cache::remember('bisabiller_wallet_balance', 300, function () {
            return (new BisaTopup())->walletBalance();
        });

        // Gap-based: rawGap after accounting for pending withdrawals reflects only QRIS settlement delay
        $rawGap                 = ($actualBalance !== null) ? ($totalExpectedAll - $actualBalance) : 0;
        $pendingSettlementTotal = ($rawGap > 0) ? min($rawGap, $recentPaidTotal) : 0;
        $pendingSettlementCount = ($pendingSettlementTotal > 0) ? $recentCountTotal : 0;

        $totalExpected = $totalExpectedAll - $pendingSettlementTotal;
        $threshold     = config('services.two_fa.discrepancy_threshold', 50000);
        $discrepancy   = ($actualBalance !== null) ? ($actualBalance - $totalExpected) : null;
        $isNormal      = ($discrepancy !== null) && abs($discrepancy) <= $threshold;

        // Build breakdown rows — closure avoids duplication between page load and AJAX refresh
        $buildRows = function (int $rawGap) use (
            $allPaidByCampaign, $recentByCampaign, $completedByCampaign, $pendingWdByCampaign
        ) {
            $allCampaignIds = $allPaidByCampaign->keys()
                ->union($recentByCampaign->keys())
                ->union($completedByCampaign->keys())
                ->union($pendingWdByCampaign->keys());

            $rows = collect();
            foreach ($allCampaignIds as $campaignId) {
                $all    = $allPaidByCampaign->get($campaignId);
                $recent = $recentByCampaign->get($campaignId);
                $pendWd = $pendingWdByCampaign->get($campaignId);

                $allWalletCredit    = $all    ? (int) $all->wallet_credit    : 0;
                $recentWalletCredit = $recent ? (int) $recent->wallet_credit : 0;
                $recentTxnCount     = $recent ? (int) $recent->txn_count     : 0;

                $campaignQrisPending      = ($rawGap > 0) ? $recentWalletCredit : 0;
                $campaignQrisPendingCount = ($rawGap > 0) ? $recentTxnCount     : 0;

                $settledCredit = $allWalletCredit - $campaignQrisPending;
                $completedWd   = (int) ($completedByCampaign[$campaignId] ?? 0);
                $pendingWd     = $pendWd ? (int) $pendWd->total : 0;
                $pendingWdCnt  = $pendWd ? (int) $pendWd->cnt  : 0;
                $campaignName  = ($all ?? $recent ?? $pendWd)?->campaign?->judul ?? '—';

                $rows->push([
                    'campaign'         => $campaignName,
                    'total_qris'       => (int) (($all ?? $recent)?->total_qris ?? 0),
                    'wallet_credit'    => $settledCredit,
                    'total_withdrawn'  => $completedWd,
                    'net'              => $settledCredit - $completedWd - $pendingWd,
                    'txn_count'        => $all ? ((int) $all->txn_count - $campaignQrisPendingCount) : 0,
                    'pending_wallet'   => $campaignQrisPending,
                    'pending_count'    => $campaignQrisPendingCount,
                    'pending_wd'       => $pendingWd,
                    'pending_wd_count' => $pendingWdCnt,
                ]);
            }
            return $rows;
        };

        $rows = $buildRows($rawGap);

        if ($request->ajax()) {
            Cache::forget('bisabiller_wallet_balance');
            $actualBalance = (new BisaTopup())->walletBalance();
            // Re-cache the fresh balance so balanceHistory() (called right after by JS)
            // gets rawGap = 0 and does not show stale "Settling…" badges.
            if ($actualBalance !== null) {
                Cache::put('bisabiller_wallet_balance', $actualBalance, 300);
            }
            $rawGap                 = ($actualBalance !== null) ? ($totalExpectedAll - $actualBalance) : 0;
            $pendingSettlementTotal = ($rawGap > 0) ? min($rawGap, $recentPaidTotal) : 0;
            $pendingSettlementCount = ($pendingSettlementTotal > 0) ? $recentCountTotal : 0;
            $totalExpected          = $totalExpectedAll - $pendingSettlementTotal;
            $discrepancy            = ($actualBalance !== null) ? ($actualBalance - $totalExpected) : null;
            $isNormal               = ($discrepancy !== null) && abs($discrepancy) <= $threshold;
            $rows                   = $buildRows($rawGap);

            return response()->json([
                'actualBalance'           => $actualBalance,
                'totalExpected'           => $totalExpected,
                'discrepancy'             => $discrepancy,
                'isNormal'                => $isNormal,
                'threshold'               => $threshold,
                'pendingSettlementTotal'  => $pendingSettlementTotal,
                'pendingSettlementCount'  => $pendingSettlementCount,
                'pendingTransferTotal'    => $pendingTransferTotal,
                'pendingTransferCount'    => $pendingTransferCount,
                'settlementMinutes'       => $settlementMinutes,
                'breakdownHtml'           => view('admin-page.service.celengan-syahid.withdrawal.components._breakdown-rows', compact('rows'))->render(),
                'tfootHtml'               => $rows->count() > 0
                    ? '<tr><td colspan="6" class="ps-4 text-end br-tfoot-label">Total Expected Balance (settled)</td><td class="text-end br-tfoot-value">Rp ' . number_format($totalExpected, 0, ',', '.') . '</td></tr>'
                    : '',
                'updatedAt'               => now()->format('d M Y, H:i'),
            ]);
        }

        return view('admin-page.service.celengan-syahid.withdrawal.balance-report', [
            'rows'                   => $rows,
            'totalExpected'          => $totalExpected,
            'pendingSettlementTotal' => $pendingSettlementTotal,
            'pendingSettlementCount' => $pendingSettlementCount,
            'pendingTransferTotal'   => $pendingTransferTotal,
            'pendingTransferCount'   => $pendingTransferCount,
            'settlementMinutes'      => $settlementMinutes,
            'actualBalance'          => $actualBalance,
            'discrepancy'            => $discrepancy,
            'isNormal'               => $isNormal,
            'threshold'              => $threshold,
            'title'                  => 'Celengan Syahid',
        ]);
    }

    /* ================================================================
       BALANCE HISTORY — AJAX: unified payment + disbursement log
       ================================================================ */

    public function balanceHistory(\Illuminate\Http\Request $request)
    {
        $mdrRate = (float) config('services.bisatopup.qris_mdr_percent', 1) / 100;
        $search  = trim($request->input('search', ''));
        $type    = $request->input('type', '');
        $perPage = 20;

        $settlementMinutes = (int) config('services.bisatopup.settlement_minutes', 15);
        $cutoff            = now()->subMinutes($settlementMinutes);

        // Determine rawGap using cached balance — is_settling only true when there is an
        // actual gap to attribute. If payment already settled, rawGap shrinks to 0 and
        // the badge disappears immediately, even within the 15-minute time window.
        // Fallback is 0 (not 1): when cache is null we err on the side of NOT showing
        // stale "Settling…" badges rather than showing them incorrectly.
        $cachedBalance     = Cache::get('bisabiller_wallet_balance');
        $mdrRateLocal      = $mdrRate; // alias for closure
        $allPaidCredit     = (int) Donation::where('gateway', 'bisatopup')
                                ->where('payment_status', 'PAID')
                                ->selectRaw(
                                    'SUM(COALESCE(total_tagihan, jumlah_donasi + biaya_admin) - CEIL(COALESCE(total_tagihan, jumlah_donasi + biaya_admin) * ?)) as wc',
                                    [$mdrRateLocal]
                                )->value('wc');
        // Include PENDING withdrawals — they've already been deducted from Bisabiller wallet
        $allWithdrawn      = (int) Withdrawal::whereIn('status', ['COMPLETED', 'PENDING'])->sum('amount');
        $totalExpectedAll  = $allPaidCredit - $allWithdrawn;
        // rawGap > 0 means wallet hasn't fully reflected all PAID donations yet
        $rawGap            = ($cachedBalance !== null) ? ($totalExpectedAll - $cachedBalance) : 0;

        // ── CREDIT entries: PAID bisatopup donations ──────────────
        $donQ = Donation::where('gateway', 'bisatopup')
            ->where('payment_status', 'PAID')
            ->with('campaign:id,judul');

        if ($search) {
            $donQ->where(function ($q) use ($search) {
                $q->where('doc_no', 'like', "%{$search}%")
                  ->orWhere('nama_donatur', 'like', "%{$search}%")
                  ->orWhereHas('campaign', fn($q) => $q->where('judul', 'like', "%{$search}%"));
            });
        }

        $credits = $donQ->get()->map(function ($d) use ($mdrRate, $cutoff, $rawGap) {
            $gross  = (int) ($d->total_tagihan ?? ($d->jumlah_donasi + (int) $d->biaya_admin));
            $mdr    = (int) ceil($gross * $mdrRate);
            $credit = $gross - $mdr;
            // Only show the "Settling…" badge when:
            //  1. The payment is recent (within settlement window), AND
            //  2. There is a real gap between expectedAll and actualBalance.
            // If the payment already settled (actualBalance increased), rawGap shrinks
            // and is_settling becomes false immediately — no stale badge.
            $isSettling = $rawGap > 0 && $d->updated_at && $d->updated_at->gte($cutoff);
            return [
                'type'        => 'PAYMENT',
                'date'        => $d->updated_at,
                'reference'   => $d->doc_no,
                'campaign'    => $d->campaign->judul ?? '—',
                'amount'      => $credit,
                'is_settling' => $isSettling,
                'details'     => [
                    'donor'         => $d->nama_donatur,
                    'email'         => $d->email_donatur,
                    'jumlah_donasi' => $d->jumlah_donasi,
                    'total_tagihan' => $gross,
                    'mdr'           => $mdr,
                    'doc_no'        => $d->doc_no,
                    'campaign'      => $d->campaign->judul ?? '—',
                    'date'          => $d->updated_at ? $d->updated_at->format('d M Y, H:i') : '—',
                ],
            ];
        });

        // ── DEBIT entries: COMPLETED withdrawals ──────────────────
        $wdQ = Withdrawal::where('status', 'COMPLETED')->with('campaign:id,judul');

        if ($search) {
            $wdQ->where(function ($q) use ($search) {
                $q->where('reff_id', 'like', "%{$search}%")
                  ->orWhere('account_holder', 'like', "%{$search}%")
                  ->orWhere('bank_code', 'like', "%{$search}%")
                  ->orWhereHas('campaign', fn($q) => $q->where('judul', 'like', "%{$search}%"));
            });
        }

        $debits = $wdQ->get()->map(function ($w) {
            return [
                'type'      => 'DISBURSEMENT',
                'date'      => $w->completed_at ?? $w->executed_at,
                'reference' => $w->reff_id,
                'campaign'  => $w->campaign->judul ?? '—',
                'amount'    => -((int) $w->amount),
                'details'   => [
                    'bank_code'      => strtoupper($w->bank_code),
                    'account_number' => $w->account_number,
                    'account_holder' => $w->account_holder,
                    'amount'         => $w->amount,
                    'fee'            => $w->fee,
                    'reff_id'        => $w->reff_id,
                    'campaign'       => $w->campaign->judul ?? '—',
                    'executed_at'    => optional($w->executed_at)->format('d M Y, H:i') ?? '—',
                    'completed_at'   => optional($w->completed_at)->format('d M Y, H:i') ?? '—',
                ],
            ];
        });

        // ── Merge + type filter ───────────────────────────────────
        $all = $credits->merge($debits);
        if ($type === 'PAYMENT')      { $all = $all->filter(fn($e) => $e['type'] === 'PAYMENT'); }
        if ($type === 'DISBURSEMENT') { $all = $all->filter(fn($e) => $e['type'] === 'DISBURSEMENT'); }

        // ── Running balance (ASC order → cumulative sum) ──────────
        $asc     = $all->sortBy('date')->values();
        $running = 0;
        $asc     = $asc->map(function ($e) use (&$running) {
            $running            += $e['amount'];
            $e['balance_after']  = $running;
            return $e;
        });

        // ── Paginate descending (newest first) ────────────────────
        $desc     = $asc->reverse()->values();
        $total    = $desc->count();
        $page     = max(1, (int) $request->input('page', 1));
        $offset   = ($page - 1) * $perPage;
        $items    = $desc->slice($offset, $perPage)->values();
        $lastPage = max(1, (int) ceil($total / $perPage));

        $totalCredit = $all->filter(fn($e) => $e['amount'] > 0)->sum('amount');
        $totalDebit  = abs($all->filter(fn($e) => $e['amount'] < 0)->sum('amount'));

        return response()->json([
            'html'         => view('admin-page.service.celengan-syahid.withdrawal.components._balance-history-rows', compact('items'))->render(),
            'total'        => $total,
            'from'         => $total > 0 ? $offset + 1 : 0,
            'to'           => min($offset + $perPage, $total),
            'current_page' => $page,
            'last_page'    => $lastPage,
            'total_credit' => $totalCredit,
            'total_debit'  => $totalDebit,
        ]);
    }

    /* ================================================================
       CALLBACK — webhook from Bisabiller for disbursement status
       POST /celengan-syahid/disbursement-callback (no auth, no CSRF)
       ================================================================ */

    public function callback(Request $request, string $secret = '')
    {
        // ── URL path secret guard ───────────────────────────────────────
        // Bisabiller's Transfer callback has no signature field. We guard
        // the endpoint by embedding the secret as a path segment registered
        // in the Bisabiller dashboard, e.g.:
        //   /celengan-syahid/disbursement-callback/{BISATOPUP_CALLBACK_DISBURSEMENT_SECRET}
        // Bisabiller rejects query strings (?_sec=...) in their URL validator,
        // so a path segment is the only viable approach.
        $expected = config('services.bisatopup.callback_disbursement_secret');
        if ($expected && !hash_equals((string) $expected, $secret)) {
            Log::warning('[Withdrawal Callback] invalid URL secret — possible spoofed request', [
                'ip'      => $request->ip(),
                'reff_id' => $request->input('reff_id'),
            ]);
            return response()->json(['status' => 'unauthorized'], 401);
        }
        // ────────────────────────────────────────────────────────────────

        $payload = $request->all();
        Log::info('[Withdrawal Callback] received', ['payload' => $payload, 'ip' => $request->ip()]);

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
