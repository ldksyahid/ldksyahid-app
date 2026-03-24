<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\LibraryFunctionController as LFC;
use App\Models\Campaign;
use App\Models\Donation;
use App\Services\Xendit;
use App\Services\Wablas;
use RealRashid\SweetAlert\Facades\Alert;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\DonationInvoice;
use App\Mail\DonationSuccess;
use App\Services\GoogleDrive;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CelenganSyahidController extends Controller
{
    public $pathCampaignsGDrive = '1w48iZmjPCkYwVUL26zIj8fBIX37OMaGT';

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
        return view('landing-page.service.celengan-syahid.index', compact('campaigns', 'categories'), ['title' => 'Layanan']);
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

        return view('landing-page.service.celengan-syahid.donate-now', [
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

    public function storeDonationCampaign(Request $request)
    {
        $jumlah_donasi = (int) LFC::replaceamount($request->input('jumlah_donasi'));

        if ($jumlah_donasi < 10000) {
            Alert::warning('Maaf!', 'Silahkan masukkan donasi minimal Rp10.000');
            return Redirect::back();
        }

        if (!$request->input('g-recaptcha-response')) {
            Alert::warning('Maaf!', 'Silahkan verifikasi Captcha terlebih dahulu');
            return Redirect::back();
        }

        $campaign = Campaign::where('link', $request->input('linkcampaign'))->first();
        if (!$campaign) {
            abort(404, 'Campaign tidak ditemukan');
        }

        try {
            $external_id    = Str::random(10);
            $xendit_request = Xendit::postInvoice($external_id, $jumlah_donasi);
            $responseXendit = $xendit_request->object();

            $postDonation = DB::transaction(function () use ($request, $external_id, $jumlah_donasi, $responseXendit) {
                return Donation::createDonation(
                    $request,
                    $external_id,
                    $jumlah_donasi,
                    $responseXendit->status,
                    $responseXendit->invoice_url
                );
            });

            $carbonDate    = Carbon::parse($responseXendit->expiry_date)->setTimezone('Asia/Jakarta');
            $formattedDate = $carbonDate->isoFormat('dddd, D MMMM YYYY') . ' Pukul ' . $carbonDate->isoFormat('HH:mm');

            $data = [
                'donaturTelp'    => $request->input('no_telp_donatur'),
                'campaignName'   => $campaign->judul,
                'linkCampaign'   => $request->input('linkcampaign'),
                'donaturName'    => $request->input('nama_donatur'),
                'donaturMessage' => $request->input('pesan_donatur'),
                'donationAmount' => $request->input('jumlah_donasi'),
                'donationID'     => $postDonation->id,
                'invoiceUrl'     => $responseXendit->invoice_url,
                'merchantName'   => $responseXendit->merchant_name,
                'logo'           => $responseXendit->merchant_profile_picture_url,
                'expiredDate'    => $formattedDate,
            ];

            Wablas::sendInvoiceSimpleText($data);
            Mail::to($request->input('email_donatur'))->send(new DonationInvoice($data));

            return Redirect::route('service.celengansyahid.detail.donateNow.status', [
                'link' => $request->input('linkcampaign'),
                'id'   => $postDonation->id,
            ]);
        } catch (\Exception $e) {
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
     * Xendit payment callback (webhook).
     *
     * IMPORTANT: This route must be excluded from CSRF in
     * App\Http\Middleware\VerifyCsrfToken::$except.
     */
    public function callbackDonation()
    {
        // 1. Verify Xendit webhook token
        $webhookToken = config('services.xendit.webhook_token');
        if ($webhookToken && request()->header('x-callback-token') !== $webhookToken) {
            Log::warning('Xendit callback: invalid token', [
                'ip' => request()->ip(),
            ]);
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $dataXendit = request()->all();

        // 2. Validate required fields
        foreach (['status', 'external_id', 'amount'] as $field) {
            if (empty($dataXendit[$field])) {
                return response()->json(['message' => "Missing field: {$field}"], 400);
            }
        }

        $status      = $dataXendit['status'];
        $external_id = $dataXendit['external_id'];

        // 3. Only accept known statuses
        $allowedStatuses = ['PAID', 'PENDING', 'SETTLED', 'EXPIRED', 'FAILED'];
        if (!in_array($status, $allowedStatuses, true)) {
            return response()->json(['message' => 'Unknown status'], 400);
        }

        try {
            DB::transaction(function () use ($external_id, $dataXendit) {
                Donation::updatePaymentStatus($external_id, $dataXendit);
            });

            if ($status === 'PAID') {
                $donationData = Donation::with('campaign')->where('doc_no', $external_id)->first();
                if ($donationData) {
                    Wablas::sendPaidSimpleText([
                        'donaturName'    => $donationData->nama_donatur,
                        'donationAmount' => $donationData->jumlah_donasi,
                        'donaturTelp'    => $donationData->no_telp_donatur,
                    ]);

                    if ($donationData->email_donatur) {
                        try {
                            $pdf = PDF::loadView('print-request.donation-proof', [
                                'donation' => $donationData,
                                'campaign' => $donationData->campaign,
                            ])->setPaper('a4');

                            Mail::to($donationData->email_donatur)
                                ->send(new DonationSuccess($donationData, $pdf->output()));
                        } catch (\Exception $mailEx) {
                            Log::error('callbackDonation: email failed: ' . $mailEx->getMessage(), [
                                'external_id' => $external_id,
                            ]);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('callbackDonation error: ' . $e->getMessage(), [
                'external_id' => $external_id,
            ]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }

        return response()->json(['message' => 'OK'], 200);
    }

    public function donationStatus($link, $id)
    {
        $donation = Donation::with('campaign')
            ->where('id', $id)
            ->whereHas('campaign', fn ($q) => $q->where('link', $link))
            ->firstOrFail();

        return view('landing-page.service.celengan-syahid.donation-status', [
            'data'     => $donation,
            'campaign' => $donation->campaign,
            'title'    => 'Layanan',
        ]);
    }

    public function savePaymentDonation($link, $id)
    {
        $donation = Donation::with('campaign')
            ->where('id', $id)
            ->whereHas('campaign', fn ($q) => $q->where('link', $link))
            ->firstOrFail();

        $campaign = $donation->campaign;

        $pdf = PDF::loadView('print-request.donation-proof', compact('donation', 'campaign'));
        return $pdf->setPaper('a4')->stream('Bukti Pembayaran Donasi - ' . $donation->id . '.pdf');
    }

    /* ================================================================
       ADMIN — DONATIONS
       ================================================================ */

    public function indexAdminDonation(Request $request)
    {
        $items      = Donation::searchAdminDonations($request);
        $tableConfig = Donation::getTableConfig();

        $campaignNames = Campaign::pluck('judul', 'id')->toArray();
        $items->getCollection()->transform(function ($donation) use ($campaignNames) {
            $donation->campaign_name = $campaignNames[$donation->campaign_id] ?? '-';
            $donation->jumlah_donasi = LFC::formatRupiah($donation->jumlah_donasi);
            return $donation;
        });

        $paymentStatusOptions = Donation::getPaymentStatusOptions();
        $campaignOptions      = Donation::getCampaignOptions();

        if ($request->ajax()) {
            return response()->json([
                'tableBody'  => view('components.admin-index.index-table', compact('items', 'tableConfig'))->render(),
                'pagination' => $items->appends($request->query())->links()->render(),
                'total'      => $items->total(),
                'from'       => $items->firstItem(),
                'to'         => $items->lastItem(),
            ]);
        }

        return view('admin-page.service.celengan-syahid.donation.index',
            compact('items', 'tableConfig', 'paymentStatusOptions', 'campaignOptions'))
            ->with('title', 'Celengan Syahid');
    }

    public function destroyAdminDonation($id)
    {
        try {
            Donation::deleteDonation($id);
            return response()->json(['success' => true, 'message' => 'Donation has been deleted!']);
        } catch (\Exception $e) {
            Log::error('destroyAdminDonation: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting donation: ' . $e->getMessage()], 500);
        }
    }

    public function bulkDeleteDonation(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No donations selected for deletion'], 400);
        }

        try {
            $deleted = Donation::bulkDeleteDonations($ids);
            return response()->json(['success' => true, 'message' => "{$deleted} donation(s) have been deleted!"]);
        } catch (\Exception $e) {
            Log::error('bulkDeleteDonation: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting donations: ' . $e->getMessage()], 500);
        }
    }

    /* ================================================================
       ADMIN — CAMPAIGNS
       ================================================================ */

    public function dashboardCelenganSyahid()
    {
        $pythonExecutable = '/home/ldksyah1/virtualenv/ucupspython/3.9/bin/python';
        $scriptPath       = '/home/ldksyah1/public_html/public/machine-learning/models/donation-class-machine.py';

        $process = new Process([$pythonExecutable, $scriptPath], null, null, null, null);
        $process->start();
        $process->wait();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return view('admin-page.service.celengan-syahid.dashboard', ['title' => 'Celengan Syahid']);
    }

    public function indexAdminCampaign(Request $request)
    {
        $items       = Campaign::searchAdminCampaigns($request);
        $tableConfig = Campaign::getTableConfig();

        $items->getCollection()->transform(function ($campaign) {
            $campaign->target_biaya = LFC::formatRupiah($campaign->target_biaya);
            return $campaign;
        });

        $categoryOptions = Campaign::getCategoryOptions();

        if ($request->ajax()) {
            return response()->json([
                'tableBody'  => view('components.admin-index.index-table', compact('items', 'tableConfig'))->render(),
                'pagination' => $items->appends($request->query())->links()->render(),
                'total'      => $items->total(),
                'from'       => $items->firstItem(),
                'to'         => $items->lastItem(),
            ]);
        }

        return view('admin-page.service.celengan-syahid.campaign.index',
            compact('items', 'tableConfig', 'categoryOptions'))
            ->with('title', 'Celengan Syahid');
    }

    public function createAdminCampaign()
    {
        $provinces = Province::pluck('name', 'id');
        return view('admin-page.service.celengan-syahid.campaign.create',
            compact('provinces'), ['title' => 'Celengan Syahid']);
    }

    public function storeAdminCampaign(Request $request)
    {
        try {
            $gdriveService = new GoogleDrive($this->pathCampaignsGDrive);

            $fileNamePoster = time() . '_poster_' . $request->file('poster')->getClientOriginalName();
            $uploadResultPoster = $gdriveService->uploadImage(
                $request->file('poster'),
                $fileNamePoster,
                $this->pathCampaignsGDrive . '/' . $fileNamePoster
            );

            $uploadResultLogoPic = [];
            if ($request->hasFile('logo_pj')) {
                $fileNameLogo = time() . '_logo-pic_' . $request->file('logo_pj')->getClientOriginalName();
                $uploadResultLogoPic = $gdriveService->uploadImage(
                    $request->file('logo_pj'),
                    $fileNameLogo,
                    $this->pathCampaignsGDrive . '/' . $fileNameLogo
                );
            }

            Campaign::createCampaign($request->all(), $uploadResultPoster, $uploadResultLogoPic);

            Alert::success('Success', 'Campaign has been uploaded!');
        } catch (\Exception $e) {
            Log::error('storeAdminCampaign: ' . $e->getMessage());
            Alert::error('Error', 'Gagal menyimpan campaign: ' . $e->getMessage());
        }

        return redirect('/admin/service/celengansyahid/campaigns');
    }

    public function editAdminCampaign($id)
    {
        $province = Province::pluck('name', 'id');
        $data     = Campaign::findOrFail($id);
        return view('admin-page.service.celengan-syahid.campaign.update',
            compact('province', 'data'), ['title' => 'Celengan Syahid']);
    }

    public function updateAdminCampaign(Request $request, $id)
    {
        try {
            $gdriveService = new GoogleDrive($this->pathCampaignsGDrive);
            $campaign      = Campaign::findOrFail($id);

            if ($request->hasFile('poster')) {
                $fileNamePoster = time() . '_poster_' . $request->file('poster')->getClientOriginalName();
                $uploaded = $gdriveService->uploadImage(
                    $request->file('poster'),
                    $fileNamePoster,
                    $this->pathCampaignsGDrive . '/' . $fileNamePoster
                );
                if (!empty($uploaded)) {
                    if ($campaign->gdrive_id) {
                        $gdriveService->deleteImage($campaign->gdrive_id);
                    }
                    $campaign->update([
                        'poster'    => $uploaded['fileName'],
                        'gdrive_id' => $uploaded['gdriveID'],
                    ]);
                }
            }

            if ($request->hasFile('logo_pj')) {
                $fileNameLogo = time() . '_logo-pic_' . $request->file('logo_pj')->getClientOriginalName();
                $uploaded = $gdriveService->uploadImage(
                    $request->file('logo_pj'),
                    $fileNameLogo,
                    $this->pathCampaignsGDrive . '/' . $fileNameLogo
                );
                if (!empty($uploaded)) {
                    if ($campaign->gdrive_id_1) {
                        $gdriveService->deleteImage($campaign->gdrive_id_1);
                    }
                    $campaign->update([
                        'logo_pj'    => $uploaded['fileName'],
                        'gdrive_id_1' => $uploaded['gdriveID'],
                    ]);
                }
            }

            Campaign::updateCampaign($id, $request->all());

            toast('Campaign has been updated!', 'success')->autoClose(1500)->width('400px');
        } catch (\Exception $e) {
            Log::error('updateAdminCampaign: ' . $e->getMessage());
            Alert::error('Error', 'Gagal memperbarui campaign: ' . $e->getMessage());
        }

        return redirect('/admin/service/celengansyahid/campaigns');
    }

    public function previewAdminCampaign($id)
    {
        $province = Province::pluck('name', 'id');
        $data     = Campaign::getDataDonationCampaignById($id);
        return view('admin-page.service.celengan-syahid.campaign.view', [
            'data'     => $data,
            'title'    => 'Celengan Syahid',
            'province' => $province,
        ]);
    }

    public function destroyAdminCampaign($id)
    {
        try {
            $gdriveService = new GoogleDrive($this->pathCampaignsGDrive);
            $campaign      = Campaign::findOrFail($id);

            if ($campaign->gdrive_id) {
                $gdriveService->deleteImage($campaign->gdrive_id);
            }
            if ($campaign->gdrive_id_1) {
                $gdriveService->deleteImage($campaign->gdrive_id_1);
            }

            Campaign::deleteCampaign($id);

            return response()->json(['success' => true, 'message' => 'Campaign has been deleted!']);
        } catch (\Exception $e) {
            Log::error('destroyAdminCampaign: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting campaign: ' . $e->getMessage()], 500);
        }
    }

    public function bulkDeleteCampaign(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No campaigns selected for deletion'], 400);
        }

        try {
            $deleted = Campaign::bulkDeleteCampaigns($ids);
            return response()->json(['success' => true, 'message' => "{$deleted} campaign(s) have been deleted!"]);
        } catch (\Exception $e) {
            Log::error('bulkDeleteCampaign: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting campaigns: ' . $e->getMessage()], 500);
        }
    }

    public function storeCity(Request $request)
    {
        $dataProvince = Province::where('name', $request->input('id'))->first();
        if (!$dataProvince) {
            return response()->json([]);
        }
        $cities = City::where('province_code', $dataProvince->code)->pluck('name', 'id');
        return response()->json($cities);
    }
}
