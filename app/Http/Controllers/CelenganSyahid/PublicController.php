<?php

namespace App\Http\Controllers\CelenganSyahid;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LibraryFunctionController as LFC;
use App\Http\Requests\StoreDonationRequest;
use App\Mail\DonationInvoice;
use App\Mail\DonationSuccess;
use App\Models\Campaign;
use App\Models\Donation;
use App\Services\BisaTopup;
use App\Services\Fonnte;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Laravolt\Indonesia\Models\City;
use RealRashid\SweetAlert\Facades\Alert;

/**
 * Public-facing Celengan Syahid pages and the donation/payment flow.
 */
class PublicController extends Controller
{
    /* ================================================================
       LANDING PAGE
       ================================================================ */

    public function indexLanding(Request $request)
    {
        $query = Campaign::with(['donation' => function ($q) {
            $q->where('payment_status', 'PAID');
        }]);

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . trim($request->search) . '%');
        }

        if ($request->filled('category')) {
            $query->whereIn('kategori', (array) $request->category);
        }

        if ($request->filled('status')) {
            $selectedStatuses = (array) $request->status;
            $hasAktif    = in_array('aktif',    $selectedStatuses);
            $hasBerakhir = in_array('berakhir', $selectedStatuses);
            if ($hasAktif && !$hasBerakhir) {
                $today = now()->toDateString();
                $query->where(function ($q) use ($today) {
                    $q->whereNull('deadline')->orWhere('deadline', '>=', $today);
                });
            } elseif ($hasBerakhir && !$hasAktif) {
                $query->where('deadline', '<', now()->toDateString());
            }
        }

        if ($request->filled('organizer')) {
            $organizers = (array) $request->organizer;
            $query->where(function ($q) use ($organizers) {
                foreach ($organizers as $org) {
                    if ($org === '__ldk__') {
                        $q->orWhereNull('nama_pj');
                    } else {
                        $q->orWhere('nama_pj', $org);
                    }
                }
            });
        }

        $sort = $request->input('sort', 'newest');
        if ($sort === 'deadline') {
            $query->orderBy('deadline', 'asc');
        } elseif ($sort === 'title') {
            $query->orderBy('judul', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $campaigns = $query->paginate(9)->appends($request->except('_token'));

        if ($request->header('X-Requested-With') === 'XMLHttpRequest') {
            $html = view('landing-page.service.celengan-syahid.components._index._campaign-cards', compact('campaigns'))->render();
            return response()->json([
                'html'  => $html,
                'total' => $campaigns->total(),
                'from'  => $campaigns->firstItem() ?? 0,
                'to'    => $campaigns->lastItem() ?? 0,
            ]);
        }

        $categories = Campaign::getCategoryOptions();
        $statuses   = Campaign::getStatusOptions();
        $organizers = Campaign::getOrganizerOptions();
        return view('landing-page.service.celengan-syahid.index', compact('campaigns', 'categories', 'statuses', 'organizers'), ['title' => 'Layanan']);
    }

    public function showLanding($link)
    {
        $data = Campaign::getDataDonationCampaignByLink($link);

        if (!$data) {
            abort(404);
        }

        return view('landing-page.service.celengan-syahid.detail', [
            'data'  => $data,
            'title' => 'Layanan',
        ]);
    }

    /* ================================================================
       DONATE NOW
       ================================================================ */

    public function donateNow($link)
    {
        $data   = Campaign::where('link', $link)->firstOrFail();
        $cities = City::pluck('name', 'id');

        return view('landing-page.service.celengan-syahid.donation-form', [
            'data'   => $data,
            'title'  => 'Layanan',
            'cities' => $cities,
        ]);
    }

    /**
     * API endpoint: return jobs list (used by Select2 AJAX).
     */
    public function getJobs(Request $request)
    {
        $jobs   = config('jobs.list', []);
        $search = trim($request->input('q', ''));

        if ($search !== '') {
            $jobs = array_values(array_filter(
                $jobs,
                fn ($job) => mb_stripos($job, $search) !== false
            ));
        }

        $results = array_map(fn ($job) => ['id' => $job, 'text' => $job], $jobs);

        return response()->json(['results' => array_values($results)]);
    }

    public function storeDonationCampaign(StoreDonationRequest $request)
    {
        $jumlah_donasi = (int) LFC::replaceamount($request->input('jumlah_donasi'));

        if ($jumlah_donasi < 1000) {
            Alert::warning('Maaf!', 'Silahkan masukkan donasi minimal Rp1.000');
            return Redirect::back();
        }

        $campaign = Campaign::where('link', $request->input('linkcampaign'))->first();
        if (!$campaign) {
            abort(404, 'Campaign tidak ditemukan');
        }

        // Atomic idempotency guard — prevents double donation + double email/WA
        // from duplicate POST (cached reCAPTCHA token, network retry, etc.).
        // Cache::add() is atomic: returns false if key already exists.
        $lockKey  = 'donation_submit_' . md5($request->input('email_donatur') . $campaign->id);
        $acquired = Cache::add($lockKey, true, now()->addSeconds(30));

        if (!$acquired) {
            // Another request for the same email+campaign is in flight.
            // The first request may still be writing to DB, so retry a few times
            // before giving up — avoids the confusing warning when the donation IS
            // being created but hasn't committed yet.
            // Poll up to ~10s so we catch donations that are still waiting on a slow
            // gateway response (BisaTopup can take 5-7s). 20 × 500ms = 10 seconds.
            $recent = null;
            for ($i = 0; $i < 20; $i++) {
                $recent = Donation::where('email_donatur', $request->input('email_donatur'))
                    ->where('campaign_id', $campaign->id)
                    ->where('created_at', '>=', now()->subSeconds(30))
                    ->latest()->first();
                if ($recent) break;
                usleep(500_000); // 500ms per retry
            }

            Log::info('storeDonationCampaign: duplicate submission blocked by cache lock', [
                'donation_id' => $recent?->id,
                'ip'          => $request->ip(),
            ]);

            if ($recent) {
                return Redirect::route('service.celengansyahid.detail.donateNow.status', [
                    'link' => $request->input('linkcampaign'),
                    'id'   => $recent->id,
                ]);
            }

            // Donation still not found after retries — redirect to campaign page
            // (not the form) to prevent the user from submitting again.
            Alert::warning('Maaf!', 'Donasi kamu sedang diproses. Silakan cek email atau whatsapp untuk status donasi.');
            return Redirect::route('service.celengansyahid.detail', $request->input('linkcampaign'));
        }

        try {
            $gateway       = new BisaTopup();
            $adminFee      = (int) config('services.bisatopup.admin_fee', 0);
            $qrisPaymentId = (int) config('services.bisatopup.qris_payment_id', 33);
            $transactionId = strtoupper(Str::random(12));
            $total         = $jumlah_donasi + $adminFee;
            $expiredAt     = now()->addDay();

            $payload = [
                'payment_id'        => $qrisPaymentId,
                'username'          => config('services.bisatopup.username'),
                'signature'         => $gateway->buildSignature($transactionId),
                'expired_date'      => $expiredAt->format('Y-m-d H:i:s'),
                'nominal'           => $jumlah_donasi,
                'admin_fee'         => $adminFee,
                'transaction_id'    => $transactionId,
                'transaction_total' => $total,
                'transaction_name'  => Str::limit('Donasi ' . $campaign->judul, 49, ''),
                'transaction_desc'  => Str::limit($request->input('pesan_donatur') ?: 'Donasi Celengan Syahid', 100, ''),
                'customer_number'   => $request->input('no_telp_donatur'),
                'customer_name'     => $request->input('nama_donatur'),
                'customer_email'    => $request->input('email_donatur'),
                'item_details'      => [[
                    'item_id'          => $campaign->id,
                    'item_name'        => Str::limit($campaign->judul, 49, ''),
                    'item_price'       => $jumlah_donasi,
                    'item_total_price' => $jumlah_donasi,
                    'item_quantity'    => 1,
                ]],
            ];

            $response = $gateway->createQrisTransaction($payload);

            if (!$response || !empty($response['error'])) {
                Cache::forget($lockKey);
                Log::error('storeDonationCampaign: BisaTopup create failed', ['response' => $response]);
                Alert::error('Maaf!', 'Gagal membuat transaksi pembayaran. Silahkan coba lagi.');
                return Redirect::back();
            }

            $gatewayData    = $response['data'] ?? [];
            $statusInternal = BisaTopup::mapStatus($gatewayData['status_id'] ?? 1);

            $postDonation = DB::transaction(function () use ($request, $transactionId, $jumlah_donasi, $statusInternal, $gatewayData, $expiredAt) {
                return Donation::createDonationGateway(
                    $request,
                    $transactionId,
                    $jumlah_donasi,
                    $statusInternal,
                    $gatewayData,
                    $expiredAt
                );
            });

            $carbonDate    = $expiredAt->copy()->setTimezone('Asia/Jakarta');
            $formattedDate = $carbonDate->isoFormat('dddd, D MMMM YYYY') . ' Pukul ' . $carbonDate->isoFormat('HH:mm');
            $statusUrl     = route('service.celengansyahid.detail.donateNow.status', [
                'link' => $request->input('linkcampaign'),
                'id'   => $postDonation->id,
            ]);

            // Strip /public/ prefix that appears on shared hosting where the web server
            // root points to the project root instead of the Laravel public/ directory.
            $appUrl    = rtrim(config('app.url'), '/');
            $statusUrl = str_replace($appUrl . '/public/', $appUrl . '/', $statusUrl);

            // Simpan status URL sebagai payment_link untuk donasi QRIS
            $postDonation->updateQuietly(['payment_link' => $statusUrl]);

            $data = [
                'donaturTelp'    => $request->input('no_telp_donatur'),
                'campaignName'   => $campaign->judul,
                'linkCampaign'   => $request->input('linkcampaign'),
                'donaturName'    => $request->input('nama_donatur'),
                'donaturMessage' => $request->input('pesan_donatur'),
                'donationAmount' => $request->input('jumlah_donasi'),
                'donationID'     => $postDonation->id,
                'invoiceUrl'     => $statusUrl,
                'merchantName'   => 'UKM LDK Syahid',
                'logo'           => null,
                'expiredDate'    => $formattedDate,
            ];

            try {
                Fonnte::sendInvoiceSimpleText($data);
            } catch (\Throwable $e) {
                Log::error('storeDonationCampaign: Fonnte invoice failed: ' . $e->getMessage());
            }
            try {
                Mail::mailer('gmail')->to($request->input('email_donatur'))->send(new DonationInvoice($data));
            } catch (\Throwable $e) {
                Log::error('storeDonationCampaign: invoice email failed: ' . $e->getMessage());
            }

            return Redirect::route('service.celengansyahid.detail.donateNow.status', [
                'link' => $request->input('linkcampaign'),
                'id'   => $postDonation->id,
            ]);
        } catch (\Exception $e) {
            Cache::forget($lockKey);
            Log::error('storeDonationCampaign error: ' . $e->getMessage(), [
                'linkcampaign' => $request->input('linkcampaign'),
            ]);
            Alert::error('Maaf!', 'Terjadi kesalahan. Silahkan coba lagi.');
            return Redirect::back();
        }
    }

    public function openPaymentGateway($id)
    {
        $data = Donation::getDonationById($id);

        if (!$data || !$data->payment_link) {
            abort(404);
        }

        return redirect()->away($data->payment_link);
    }

    /**
     * BisaTopup payment gateway callback (webhook).
     *
     * IMPORTANT: This route must be excluded from CSRF in
     * App\Http\Middleware\VerifyCsrfToken::$except.
     */
    public function callbackDonation()
    {
        $payload = request()->all();

        Log::info('[Callback] received', [
            'payload'      => $payload,
            'content_type' => request()->header('Content-Type'),
            'ip'           => request()->ip(),
        ]);

        $transactionId = $payload['transaction_id'] ?? null;
        $statusId      = $payload['status_id'] ?? null;

        // BisaTopup "Test" button sends either:
        //   (a) general callback: no transaction_id/status_id → empty payload
        //   (b) payment gateway callback: transaction_id="TEST-XXX" + signature="testing"
        // Both must return HTTP 200 / "1" so the dashboard shows green.
        $isTest = !$transactionId
            || $statusId === null
            || str_starts_with((string) $transactionId, 'TEST-')
            || ($payload['signature'] ?? '') === 'testing';

        if ($isTest) {
            Log::info('[Callback] test payload, acknowledging', ['transaction_id' => $transactionId]);
            return response('1', 200)->header('Content-Type', 'text/plain');
        }

        // Signature check — lenient in DEV (so we can observe the real signature),
        // enforced only when env=live AND the enforce flag is on.
        $gateway = new BisaTopup();
        if (!$gateway->verifyCallbackSignature($payload)) {
            Log::warning('[Callback] signature mismatch', [
                'transaction_id' => $transactionId,
                'received_sig'   => $payload['signature'] ?? null,
            ]);
            if (config('services.bisatopup.env') === 'live'
                && config('services.bisatopup.enforce_callback_signature', false)) {
                return response('0', 401)->header('Content-Type', 'text/plain');
            }
        }

        $statusInternal = BisaTopup::mapStatus($statusId);

        try {
            $donation = Donation::where('doc_no', $transactionId)->first();
            if (!$donation) {
                Log::warning('[Callback] donation not found', ['transaction_id' => $transactionId]);
                return response('0', 404)->header('Content-Type', 'text/plain');
            }

            // Idempotency: once finalized as PAID, just acknowledge.
            if ($donation->payment_status === 'PAID') {
                Log::info('[Callback] already PAID, idempotent ack', ['transaction_id' => $transactionId]);
                return response('1', 200)->header('Content-Type', 'text/plain');
            }

            DB::transaction(function () use ($donation, $statusInternal, $statusId, $payload) {
                $donation->update([
                    'payment_status'    => $statusInternal,
                    'status_id'         => $statusId,
                    'total_tagihan'     => $payload['transaction_total'] ?? $donation->total_tagihan,
                    'metode_pembayaran' => $payload['payment'] ?? $donation->metode_pembayaran,
                ]);
            });

            Log::info('[Callback] status updated', [
                'transaction_id' => $transactionId,
                'status'         => $statusInternal,
                'status_id'      => $statusId,
            ]);

            if ($statusInternal === 'PAID') {
                $donationData = Donation::with('campaign')->where('doc_no', $transactionId)->first();
                if ($donationData) {
                    try {
                        Fonnte::sendPaidSimpleText([
                            'donaturName'    => $donationData->nama_donatur,
                            'donationAmount' => $donationData->jumlah_donasi,
                            'donaturTelp'    => $donationData->no_telp_donatur,
                        ]);
                    } catch (\Throwable $e) {
                        Log::error('callbackDonation: Fonnte paid failed: ' . $e->getMessage());
                    }

                    if ($donationData->email_donatur) {
                        try {
                            $pdf = Pdf::loadView('print-request.donation-proof', [
                                'donation' => $donationData,
                                'campaign' => $donationData->campaign,
                            ])->setPaper('a4');

                            Mail::mailer('gmail')
                                ->to($donationData->email_donatur)
                                ->send(new DonationSuccess($donationData, $pdf->output()));
                        } catch (\Exception $mailEx) {
                            Log::error('callbackDonation: email failed: ' . $mailEx->getMessage(), [
                                'transaction_id' => $transactionId,
                            ]);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('[Callback] error: ' . $e->getMessage(), [
                'transaction_id' => $transactionId,
            ]);
            return response('0', 500)->header('Content-Type', 'text/plain');
        }

        return response('1', 200)->header('Content-Type', 'text/plain');
    }

    public function donationStatus($link, $id)
    {
        $donation = Donation::with('campaign')
            ->where('id', $id)
            ->whereHas('campaign', fn ($q) => $q->where('link', $link))
            ->firstOrFail();

        return view('landing-page.service.celengan-syahid.payment-status', [
            'data'     => $donation,
            'campaign' => $donation->campaign,
            'title'    => 'Layanan',
        ]);
    }

    public function checkPaymentStatus($id)
    {
        $donation = Donation::select('payment_status')->find($id);
        if (!$donation) {
            return response()->json(['status' => 'NOT_FOUND'], 404);
        }
        return response()->json(['status' => $donation->payment_status]);
    }

    public function savePaymentDonation($link, $id)
    {
        $donation = Donation::with('campaign')
            ->where('id', $id)
            ->whereHas('campaign', fn ($q) => $q->where('link', $link))
            ->firstOrFail();

        $campaign = $donation->campaign;

        $pdf = Pdf::loadView('print-request.donation-proof', compact('donation', 'campaign'));
        return $pdf->setPaper('a4')->download('Bukti Pembayaran Donasi - ' . $donation->id . '.pdf');
    }
}
