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
        return $this->belongTo('App\Models\Campaign', 'campaign_id');
    }
}
