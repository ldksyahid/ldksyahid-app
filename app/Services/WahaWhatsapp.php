<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\LibraryFunctionController as LFC;
use App\Models\MsSetting;
use App\Constants\SettingKey\Key1;
use App\Constants\SettingKey\Key2;

class WahaWhatsapp
{
    /**
     * Kirim pesan teks WhatsApp menggunakan WAHA API.
     *
     * @param  string  $to       Nomor tujuan, format: +62xxx atau 62xxx (tanpa @c.us)
     * @param  string  $text     Isi pesan
     * @param  string|null $session  Nama session WAHA (default dari .env)
     * @return array             Response dari API
     */
    public static function sendText(string $to, string $text, string $session = null): array
    {
        try {
            $baseUrl = rtrim(config('services.waha.base_url', 'https://waha.devlike.pro'), '/');
            $apiKey  = config('services.waha.api_key', '');
            $session = $session ?? config('services.waha.session', 'default');
            $chatId  = self::formatPhone($to);

            $response = Http::withHeaders([
                'X-Api-Key'    => $apiKey,
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ])->post("{$baseUrl}/api/sendText", [
                'session' => $session,
                'chatId'  => $chatId,
                'text'    => $text,
            ]);

            return [
                'success' => $response->successful(),
                'status'  => $response->status(),
                'body'    => $response->json(),
            ];

        } catch (\Throwable $e) {
            Log::error('[WahaWhatsapp] Gagal mengirim pesan WA', [
                'to'      => $to,
                'error'   => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'status'  => 0,
                'body'    => ['error' => $e->getMessage()],
            ];
        }
    }

    /**
     * Format nomor telepon ke format chatId WAHA ({number}@c.us).
     * Input bisa: +62821..., 62821..., 0821...
     */
    public static function formatPhone(string $phone): string
    {
        // Hapus karakter non-digit kecuali awalan +
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Ganti awalan 0 dengan 62
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        return $phone . '@c.us';
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Template Pesan
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Kirim notifikasi request shortlink baru ke admin/operator.
     *
     * @param  array   $data  Data dari form shortlink (name, email, whatsapp, defaultLink, customLink, note)
     * @param  string  $to    Nomor tujuan (override manual, opsional)
     * @return array
     */
    public static function sendShortlinkRequestNotif(array $data, string $to = null): array
    {
        if ($to === null) {
            $fromDb = MsSetting::getSettingValue1(Key1::WAHA, Key2::NotifShortlinkTo);
            $to     = !empty($fromDb) ? $fromDb : '62895394755672';
        }

        $text = self::buildShortlinkRequestMessage($data);

        return self::sendText($to, $text);
    }

    /**
     * Kirim invoice donasi ke donatur (pengganti Wablas::sendInvoiceSimpleText).
     *
     * @param  array  $data  Keys: donaturTelp, donaturName, campaignName, donationAmount, invoiceUrl, expiredDate
     * @return array
     */
    public static function sendDonationInvoice(array $data): array
    {
        $to   = $data['donaturTelp'];
        $text = self::buildDonationInvoiceMessage($data);

        return self::sendText($to, $text);
    }

    /**
     * Kirim konfirmasi donasi berhasil ke donatur (pengganti Wablas::sendPaidSimpleText).
     *
     * @param  array  $data  Keys: donaturTelp, donaturName, donationAmount
     * @return array
     */
    public static function sendDonationPaid(array $data): array
    {
        $to   = $data['donaturTelp'];
        $text = self::buildDonationPaidMessage($data);

        return self::sendText($to, $text);
    }

    /**
     * Susun teks notifikasi request shortlink.
     */
    private static function buildShortlinkRequestMessage(array $data): string
    {
        $name        = $data['name']        ?? '-';
        $email       = $data['email']       ?? '-';
        $whatsapp    = $data['whatsapp']    ?? '-';
        $defaultLink = $data['defaultLink'] ?? '-';
        $customLink  = $data['customLink']  ?? '-';
        $note        = $data['note']        ?? '-';

        return implode("\n", [
            "🔗 *[REQUEST SHORTLINK BARU]* 🔗",
            "",
            "_Assalamu'alaikum_ 😊",
            "",
            "Ada permintaan *Perpendek URL* baru yang masuk di LDK Syahid:",
            "",
            "👤 *Nama:* {$name}",
            "📧 *Email:* {$email}",
            "📱 *WhatsApp:* {$whatsapp}",
            "🔗 *Link Asli:*",
            "{$defaultLink}",
            "✨ *Custom Link:*",
            "{$customLink}",
            "📝 *Catatan:*",
            "{$note}",
            "",
            "Segera proses permintaan ini melalui panel admin:",
            "🔐 " . rtrim(config('app.url'), '/') . "/login",
            "",
            "_Terimakasih_ 🙏",
            "_Wassalamu'alaikum_",
            "",
            "#LDKSyahid",
            "#UINJakarta",
        ]);
    }

    /**
     * Susun teks invoice donasi.
     */
    private static function buildDonationInvoiceMessage(array $data): string
    {
        $donaturName    = $data['donaturName']    ?? '-';
        $campaignName   = $data['campaignName']   ?? '-';
        $donationAmount = $data['donationAmount'] ?? '-';
        $invoiceUrl     = $data['invoiceUrl']     ?? '-';
        $expiredDate    = $data['expiredDate']    ?? '-';

        return implode("\n", [
            "💛 *[INVOICE DONASI - CELENGAN SYAHID]* 💛",
            "➖➖➖➖➖➖➖➖➖➖➖➖",
            "",
            "_Assalamu'alaikum, {$donaturName}_ 😊",
            "",
            "Jazakallah khairan katsiran atas niat baikmu untuk berdonasi! 🤲",
            "",
            "Berikut detail donasimu:",
            "📌 *Campaign :* {$campaignName}",
            "💰 *Jumlah   :* {$donationAmount}",
            "⏳ *Jatuh Tempo :* {$expiredDate} WIB",
            "",
            "Yuk segera selesaikan donasimu melalui link di bawah ini:",
            "👇",
            "{$invoiceUrl}",
            "",
            "📧 _Informasi lengkap juga sudah kami kirimkan ke email kamu ya._",
            "",
            "Terimakasih telah menjadi bagian dari *Manusia Baik* 💚",
            "",
            "_Wassalamu'alaikum_ 😇",
            "➖➖➖➖➖➖➖➖➖➖➖➖",
            "🌐 ldksyah.id/Medsos",
            "#LDKSyahid #CelenganSyahid #KitaAdalahSaudara",
        ]);
    }

    /**
     * Susun teks konfirmasi donasi berhasil.
     */
    private static function buildDonationPaidMessage(array $data): string
    {
        $donaturName    = $data['donaturName']    ?? '-';
        $donationAmount = LFC::formatRupiah($data['donationAmount'] ?? 0);

        return implode("\n", [
            "✅ *[DONASI BERHASIL - CELENGAN SYAHID]* ✅",
            "➖➖➖➖➖➖➖➖➖➖➖➖",
            "",
            "_Assalamu'alaikum, {$donaturName}_ 😊",
            "",
            "Alhamdulillah! Donasimu telah *berhasil* kami terima. 🎉",
            "",
            "💰 *Jumlah Donasi :* {$donationAmount}",
            "",
            "📧 _Bukti donasi & invoice sudah kami kirimkan ke email kamu._",
            "   Simpan baik-baik ya sebagai tanda kebaikanmu! 💚",
            "",
            "Jazakallah khairan katsiran atas kepercayaanmu.",
            "Semoga donasimu menjadi amal jariyah yang terus mengalir 🤲",
            "",
            "_Wassalamu'alaikum_ 😇",
            "➖➖➖➖➖➖➖➖➖➖➖➖",
            "🌐 ldksyah.id/Medsos",
            "#LDKSyahid #CelenganSyahid #KitaAdalahSaudara",
        ]);
    }
}
