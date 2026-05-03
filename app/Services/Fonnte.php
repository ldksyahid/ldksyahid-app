<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\LibraryFunctionController as LFC;

class Fonnte
{
    private static function send(string $target, string $message): ?array
    {
        $token = env('FONNTE_TOKEN');

        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target'      => $target,
            'message'     => $message,
            'countryCode' => '62',
        ]);

        $result = $response->json();

        if (!$response->successful()) {
            Log::error('Fonnte send failed', [
                'target'   => $target,
                'response' => $result,
            ]);
        }

        return $result;
    }

    public static function sendInvoiceSimpleText($data)
    {
        $message = "🚨 *[INVOICE DONASI]* 🚨\n\n_Assalammualaikum, ".$data['donaturName']."_ 😊\n\nJazakallah Khairan Katsiiran karena kamu telah ingin melakukan donasi untuk campaign *" .$data['campaignName']. "* dengan jumlah donasi  _*".$data['donationAmount']."*_ . Yuk segera transfer donasimu pada link dibawah ini sebelum jatuh tempo pada  _" .$data['expiredDate']. " WIB_\n\n" .$data['invoiceUrl']. "\n\n_*Informasi Lengkap silahkan cek email kamu yaaa_ 😃\n\nTerimakasih telah menjadi bagian dari Manusia Baik\n\n_Wassalammu'alaikum_ 😇\n\n#LDKSyahid\n#KitaAdalahSaudara\n#FSLDKBanten\n#UINJakarta\n#CelenganSyahid\n➖➖➖➖➖➖➖➖➖\nMedia Sosial LDK Syahid\nldksyah.id/Medsos";

        return self::send($data['donaturTelp'], $message);
    }

    public static function sendPaidSimpleText($data)
    {
        $message = "🚨 *[DONASI BERHASIL]* 🚨\n\n_Assalammualaikum, ".$data['donaturName']."_ 😊\n\nAlhamdulillah Jazakallah Khairan Katsiiran telah berdonasi sebesar  _*".LFC::formatRupiah($data['donationAmount'])."*_\n\nSegera cek email *Invoice Donasimu* kembali yaaa untuk melihat _Status Donasimu_ dan jangan lupa untuk menyimpan bukti donasi nyaaa 😁\n\nTerimakasih telah menjadi bagian dari Manusia Baik\n\n_Wassalammu'alaikum_ 😇\n\n#LDKSyahid\n#KitaAdalahSaudara\n#FSLDKBanten\n#UINJakarta\n#CelenganSyahid\n➖➖➖➖➖➖➖➖➖\nMedia Sosial LDK Syahid\nldksyah.id/Medsos";

        return self::send($data['donaturTelp'], $message);
    }
}
