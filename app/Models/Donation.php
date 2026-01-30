<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;
use Illuminate\Http\Request;

class Donation extends Model
{
    use HasFactory, UsesUuid;
    protected $guarded =[];

    protected static array $allowedSorts = [
        'nama_donatur',
        'jumlah_donasi',
        'created_at',
        'payment_status',
    ];

    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'No donations found',
            'emptyIcon' => 'fa-donate',
            'colspan' => 9,
            'columns' => [
                [
                    'key' => 'nama_donatur',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'jumlah_donasi',
                    'type' => 'text',
                    'class' => 'text-center',
                    'formatter' => 'rupiah',
                ],
                [
                    'key' => 'created_at',
                    'type' => 'datetime',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'campaign_name',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'payment_status',
                    'type' => 'badge',
                    'class' => 'text-center',
                    'badgeMap' => [
                        'PENDING' => 'bg-warning',
                        'PAID' => 'bg-success',
                    ],
                    'badgeDefault' => 'bg-danger',
                ],
                [
                    'key' => 'payment_link',
                    'type' => 'link',
                    'class' => 'text-center',
                    'fallback' => '-',
                ],
            ],
            'actions' => [
                'delete' => [
                    'enabled' => true,
                    'btnClass' => 'delete-donation-btn',
                ],
            ],
        ];
    }

    public static function getPaymentStatusOptions(): array
    {
        return self::select('payment_status')
            ->distinct()
            ->orderBy('payment_status')
            ->pluck('payment_status', 'payment_status')
            ->filter()
            ->toArray();
    }

    public static function getCampaignOptions(): array
    {
        return Campaign::select('id', 'judul')
            ->orderBy('judul')
            ->pluck('judul', 'id')
            ->toArray();
    }

    public static function searchAdminDonations(Request $request)
    {
        $query = self::query();

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('campaign_id')) {
            $query->where('campaign_id', $request->campaign_id);
        }

        if ($request->filled('created_at_start') && $request->filled('created_at_end')) {
            $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->created_at_start)->startOfDay();
            $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->created_at_end)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        if (!in_array($sortBy, static::$allowedSorts)) {
            $sortBy = 'created_at';
        }

        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate(15)->appends($request->query());
    }

    public static function bulkDeleteDonations(array $ids): int
    {
        return self::whereIn('id', $ids)->delete();
    }

    public static function createDonation(Request $request, $external_id, $jumlah_donasi, $payment_status, $payment_link)
    {
        $pesan_donatur = $request->input('pesan_donatur') ?? "Bismillah Semoga Berkah yaaa ! tetap Semangat Semuanya !!";
        $postDonation = Donation::create([
            'doc_no' => $external_id,
            "jumlah_donasi" => $jumlah_donasi,
            "nama_donatur" => $request->input('nama_donatur'),
            "email_donatur" => $request->input('email_donatur'),
            "no_telp_donatur" => $request->input('no_telp_donatur'),
            "pesan_donatur" => $pesan_donatur,
            "captcha" => $request->input('g-recaptcha-response'),
            "campaign_id" => $request->input('postdonation'),
            'payment_status' => $payment_status,
            'payment_link' => $payment_link,
            'usia' => $request->input('usia_donatur'),
            'domisili' => $request->input('domisili_donatur'),
            'pekerjaan' => $request->input('pekerjaan_donatur'),
        ]);
        return $postDonation;
    }

    public static function getDonationById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function updatePaymentStatus($docNo, $dataXendit)
    {
        $adjustedReceivedAmount = isset($dataXendit['adjusted_received_amount']) ? $dataXendit['adjusted_received_amount'] : 0;
        $biayaAdmin = $adjustedReceivedAmount > 0 ? $dataXendit['amount'] - $adjustedReceivedAmount : 0;
        return self::where('doc_no', $docNo)->update([
            'payment_status' => $dataXendit['status'],
            'metode_pembayaran' => $dataXendit['payment_method'],
            'nama_merchant' => $dataXendit['payment_channel'],
            'biaya_admin' => $biayaAdmin,
            'total_tagihan' => $dataXendit['amount']
        ]);
    }

    public static function deleteDonation($id)
    {
        $donation = Donation::find($id);

        if ($donation) {
            $donation->delete();
        }
    }

    public function campaign() {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id');
    }
}
