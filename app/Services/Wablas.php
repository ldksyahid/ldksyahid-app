<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\LibraryFunctionController as LFC;

class Wablas
{
    private static $token = "vcjV9udzhdRgDEdMgMDQ0cQvQVurz5r5Z2jcVT79mITdqLnoCCWQprFb8Ars87WU";
    private static $urlSendSimpleText = "https://texas.wablas.com/api/send-message";

    public static function sendInvoiceSimpleText($data)
    {
        $message = "🚨 *[INVOICE DONASI]* 🚨\n\n_Assalammualaikum, ".$data['donaturName']."_ 😊\n\nJazakallah Khairan Katsiiran karena kamu telah ingin melakukan donasi untuk campaign *" .$data['campaignName']. "* dengan jumlah donasi  _*".$data['donationAmount']."*_ . Yuk segera transfer donasimu pada link dibawah ini sebelum jatuh tempo pada  _" .$data['expiredDate']. " WIB_\n\n" .$data['invoiceUrl']. "\n\n_*Informasi Lengkap silahkan cek email kamu yaaa_ 😃\n\nTerimakasih telah menjadi bagian dari Manusia Baik\n\n_Wassalammu'alaikum_ 😇\n\n#LDKSyahid\n#KitaAdalahSaudara\n#FSLDKBanten\n#UINJakarta\n#CelenganSyahid\n➖➖➖➖➖➖➖➖➖\nMedia Sosial LDK Syahid\nldksyah.id/Medsos";
        $params = [
            'phone' => $data['donaturTelp'],
            'message' => $message,
            'token' => self::$token
        ];

        try {
            $response = Http::get(self::$urlSendSimpleText, $params);
            if ($response->failed()) {
                Log::error('[Wablas] sendInvoiceSimpleText HTTP error', [
                    'phone'  => $data['donaturTelp'] ?? null,
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            }
            return $response->json();
        } catch (\Throwable $e) {
            Log::error('[Wablas] sendInvoiceSimpleText exception: ' . $e->getMessage(), [
                'phone' => $data['donaturTelp'] ?? null,
            ]);
            return null;
        }
    }

    public static function sendPaidSimpleText($data)
    {
        $message = "🚨 *[DONASI BERHASIL]* 🚨\n\n_Assalammualaikum, ".$data['donaturName']."_ 😊\n\nAlhamdulillah Jazakallah Khairan Katsiiran telah berdonasi sebesar  _*".LFC::formatRupiah($data['donationAmount'])."*_\n\nSegera cek email *Invoice Donasimu* kembali yaaa untuk melihat _Status Donasimu_ dan jangan lupa untuk menyimpan bukti donasi nyaaa 😁\n\nTerimakasih telah menjadi bagian dari Manusia Baik\n\n_Wassalammu'alaikum_ 😇\n\n#LDKSyahid\n#KitaAdalahSaudara\n#FSLDKBanten\n#UINJakarta\n#CelenganSyahid\n➖➖➖➖➖➖➖➖➖\nMedia Sosial LDK Syahid\nldksyah.id/Medsos";

        $params = [
            'phone' => $data['donaturTelp'],
            'message' => $message,
            'token' => self::$token
        ];

        try {
            $response = Http::get(self::$urlSendSimpleText, $params);
            if ($response->failed()) {
                Log::error('[Wablas] sendPaidSimpleText HTTP error', [
                    'phone'  => $data['donaturTelp'] ?? null,
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            }
            return $response->json();
        } catch (\Throwable $e) {
            Log::error('[Wablas] sendPaidSimpleText exception: ' . $e->getMessage(), [
                'phone' => $data['donaturTelp'] ?? null,
            ]);
            return null;
        }
    }
}
