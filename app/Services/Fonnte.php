<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\LibraryFunctionController as LFC;
use Illuminate\Support\Facades\Auth;
use App\Models\MsSetting;
use App\Constants\SettingKey\Key1;
use App\Constants\SettingKey\Key2;

class Fonnte
{
    public static function send(string $target, string $message): ?array
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

    public static function sendShortlinkRequestNotification($data)
    {
        $appUrl = config('app.url');
        $adminUrl = $appUrl . '/admin/reqservice/shortlink';
        $date = now()->format('d M Y, H:i') . ' WIB';

        $message = "📩 *[REQUEST SHORTLINK #" . $data['requestId'] . "]* 📩\n\n"
            . "_Permintaan shortlink baru!_\n\n"
            . "➖➖➖➖➖➖➖➖➖\n"
            . "📋 *Detail Permintaan:*\n\n"
            . "👤 *Nama:* " . $data['name'] . "\n"
            . "📧 *Email:* " . $data['email'] . "\n"
            . "📱 *WhatsApp:* " . $data['whatsapp'] . "\n\n"
            . "🔗 *Link Asli:*\n" . $data['defaultLink'] . "\n\n"
            . "✂️ *Custom Link yang Diminta:*\n" . $data['customLink'] . "\n\n"
            . "📝 *Catatan:*\n" . $data['note'] . "\n\n"
            . "🕐 *Waktu Request:* " . $date . "\n"
            . "➖➖➖➖➖➖➖➖➖\n\n"
            . "Balas *YES* untuk _approve_ atau *NO* untuk _tolak_ permintaan ini.\n\n"
            . "Atau proses manual via halaman admin:\n"
            . $adminUrl . "\n\n"
            . "#LDKSyahid\n#LayananShortlink";

        return self::send($data['cpPhone'], $message);
    }

    public static function sendShortlinkApproved($data)
    {
        $angkatan = MsSetting::getSettingValue1(Key1::LAYANAN, 'Hashtag Angkatan Shortlink') ?: 'PendarCakrawala';
        $cp = MsSetting::getSettingValue1(Key1::LAYANAN, Key2::CpShortlink) ?: '-';
        $namePerson = MsSetting::getSettingValue1(Key1::LAYANAN, 'Name Person Shortlink') ?: 'Admin';

        $message = "*[KUSTOM URL KAMU SUDAH JADI]*\n\n"
            . "_Assalammu'alaikum_\n\n"
            . "Halo {$data['name']} 😀\n\n"
            . "Berikut hasil link yang telah kami kustom:\n\n"

            . "🔗 *Link Kustom:*\n{$data['shortlinkUrl']}\n\n"
            . "🌐 *Link Asal:*\n{$data['defaultLink']}\n\n"

            . "*Link tersebut wajib digunakan dengan sebagaimana mestinya*\n\n"

            // ✅ tambah nama admin
            . "Jika ada kendala, hubungi admin ({$namePerson}):\n"
            . "📱 {$cp}\n\n"

            . "Terimakasih {$data['name']} telah menggunakan layanan kami 😉\n\n"
            . "_Wassalammua'laikum_\n\n"
            . "#KitaAdalahSaudara\n"
            . "#LDKSyahid\n"
            . "#{$angkatan}\n"
            . "#UINJakarta";

        return self::send($data['whatsapp'], $message);
    }

    public static function sendShortlinkRejected($data)
    {
        $angkatan = MsSetting::getSettingValue1(Key1::LAYANAN, 'Hashtag Angkatan Shortlink') ?: 'PendarCakrawala';
        $cp = MsSetting::getSettingValue1(Key1::LAYANAN, Key2::CpShortlink) ?: '-';
        $namePerson = MsSetting::getSettingValue1(Key1::LAYANAN, 'Name Person Shortlink') ?: 'Admin';

        $message = "*[KUSTOM URL TIDAK DAPAT DIPROSES]*\n\n"
            . "_Assalammu'alaikum_\n\n"
            . "Halo {$data['name']} 🙏\n\n"

            . "✂️ *Custom Link:*\n{$data['customLink']}\n\n"
            . "🌐 *Link Asal:*\n{$data['defaultLink']}\n\n"

            . "Mohon maaf, permintaan tersebut belum dapat kami proses saat ini.\n\n"

            // ✅ tambah nama admin
            . "Silakan hubungi admin ({$namePerson}) untuk informasi lebih lanjut:\n"
            . "📱 {$cp}\n\n"

            . "Terimakasih atas pengertiannya 🙏\n\n"
            . "_Wassalammua'laikum_\n\n"
            . "#KitaAdalahSaudara\n"
            . "#LDKSyahid\n"
            . "#{$angkatan}\n"
            . "#UINJakarta";

        return self::send($data['whatsapp'], $message);
    }
}
