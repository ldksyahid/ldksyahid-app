<?php

namespace App\Services;

use App\Jobs\SendSingleWhatsAppJob;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\LibraryFunctionController as LFC;
use App\Models\Donation;
use App\Models\MsSetting;
use App\Models\Withdrawal;
use App\Constants\SettingKey\Key1;
use App\Constants\SettingKey\Key2;

class WhatsApp
{
    /**
     * Send a single WhatsApp message. Only dispatches a queued job — every
     * message stays behind the `send-whatsapp` rate limiter instead of
     * flooding the account with unthrottled, back-to-back sends. Actual
     * delivery happens in SendSingleWhatsAppJob::handle() via
     * App\Services\Kirimdev.
     *
     * $templateName/$templateParams are carried alongside $message so the
     * job can send via Kirimdev's approved Message Template (positional
     * {{1}}, {{2}}... parameters, in the same order as $templateParams).
     * Keep $templateParams in the exact order the corresponding template's
     * placeholders expect — see App\Console\Commands\SyncKirimdevTemplates
     * for each template's body.
     *
     * $templateName is left null for ad-hoc admin notices (e.g.
     * WhatsAppInboundHandler's YES/NO reply confirmations) that have no
     * fixed template — those are always a business reply within an active
     * 24h session (the admin just messaged in), which Meta allows as
     * freeform text, so Kirimdev sends them as a plain text message instead
     * of a template.
     *
     * $buttonPayloads: ordered payload strings for the template's
     * quick-reply BUTTONS component, if it has one (see
     * Kirimdev::deliver()) — leave empty for templates with no buttons.
     */
    public static function send(string $target, string $message, ?string $templateName = null, array $templateParams = [], array $buttonPayloads = []): void
    {
        // Random 0-8s jitter so messages dispatched at nearly the same
        // instant (e.g. notifyAdmin + sendShortlinkApproved in the same
        // request) don't fire in the exact same second.
        //
        // ->onQueue('whatsapp'): a separate queue from 'default'/'email'
        // (used by SendSingleMailJob) — so WhatsApp jobs are never stuck
        // behind an email backlog.
        SendSingleWhatsAppJob::dispatch($target, $message, $templateName, $templateParams, $buttonPayloads)
            ->onQueue('whatsapp')
            ->delay(now()->addSeconds(rand(0, 8)));
    }

    public static function sendInvoiceSimpleText($data)
    {
        $message = "🚨 *[INVOICE DONASI]* 🚨\n\n_Assalammualaikum, ".$data['donaturName']."_ 😊\n\nJazakallah Khairan Katsiiran karena kamu telah ingin melakukan donasi untuk campaign *" .$data['campaignName']. "* dengan jumlah donasi  _*".$data['donationAmount']."*_ . Yuk segera transfer donasimu pada link dibawah ini sebelum jatuh tempo pada  _" .$data['expiredDate']. " WIB_\n\n" .$data['invoiceUrl']. "\n\n_*Informasi Lengkap silahkan cek email kamu yaaa_ 😃\n\nTerimakasih telah menjadi bagian dari Manusia Baik\n\n_Wassalammu'alaikum_ 😇\n\n#LDKSyahid\n#KitaAdalahSaudara\n#FSLDKBanten\n#UINJakarta\n#CelenganSyahid\n➖➖➖➖➖➖➖➖➖\nMedia Sosial LDK Syahid\nldksyah.id/Medsos";

        return self::send($data['donaturTelp'], $message, 'invoice_donasi_v2', [
            $data['donaturName'],
            $data['campaignName'],
            $data['donationAmount'],
            $data['expiredDate'],
            $data['invoiceUrl'],
        ]);
    }

    public static function sendPaidSimpleText($data)
    {
        $message = "🚨 *[DONASI BERHASIL]* 🚨\n\n_Assalammualaikum, ".$data['donaturName']."_ 😊\n\nAlhamdulillah Jazakallah Khairan Katsiiran telah berdonasi sebesar  _*".LFC::formatRupiah($data['donationAmount'])."*_\n\nSegera cek email *Invoice Donasimu* kembali yaaa untuk melihat _Status Donasimu_ dan jangan lupa untuk menyimpan bukti donasi nyaaa 😁\n\nTerimakasih telah menjadi bagian dari Manusia Baik\n\n_Wassalammu'alaikum_ 😇\n\n#LDKSyahid\n#KitaAdalahSaudara\n#FSLDKBanten\n#UINJakarta\n#CelenganSyahid\n➖➖➖➖➖➖➖➖➖\nMedia Sosial LDK Syahid\nldksyah.id/Medsos";

        return self::send($data['donaturTelp'], $message, 'donasi_berhasil_v2', [
            $data['donaturName'],
            LFC::formatRupiah($data['donationAmount']),
        ]);
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

        // Order must match the 'request_shortlink_v6' template's {{1}}..{{7}}
        // — requestId first since it's the first variable to appear in the
        // template body (Meta requires ascending first-use order). Switched
        // ahead of Meta approval — per explicit user instruction — so sends
        // will fail/retry via the queue's backoff until Meta approves it.
        // Button payloads must match WhatsAppInboundHandler::
        // handleButtonReply()'s expected 'approve'/'reject' strings, in the
        // same order as the template's Approve/Reject buttons.
        return self::send($data['cpPhone'], $message, 'request_shortlink_v6', [
            $data['requestId'],
            $data['name'],
            $data['email'],
            $data['whatsapp'],
            $data['defaultLink'],
            $data['customLink'],
            $data['note'],
        ], ['approve', 'reject']);
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

            . "Jika ada kendala, hubungi admin ({$namePerson}):\n"
            . "📱 {$cp}\n\n"

            . "Terimakasih {$data['name']} telah menggunakan layanan kami 😉\n\n"
            . "_Wassalammua'laikum_\n\n"
            . "#KitaAdalahSaudara\n"
            . "#LDKSyahid\n"
            . "#{$angkatan}\n"
            . "#UINJakarta";

        return self::send($data['whatsapp'], $message, 'shortlink_disetujui_v2', [
            $data['name'],
            $data['shortlinkUrl'],
        ]);
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

            . "Silakan hubungi admin ({$namePerson}) untuk informasi lebih lanjut:\n"
            . "📱 {$cp}\n\n"

            . "Terimakasih atas pengertiannya 🙏\n\n"
            . "_Wassalammua'laikum_\n\n"
            . "#KitaAdalahSaudara\n"
            . "#LDKSyahid\n"
            . "#{$angkatan}\n"
            . "#UINJakarta";

        return self::send($data['whatsapp'], $message, 'shortlink_ditolak_v2', [
            $data['name'],
            $data['customLink'],
        ]);
    }

    /**
     * Notify the campaign's PIC (Campaign.telp_pj) whenever a donation is
     * marked PAID. Skips silently (logs info) if the campaign has no PIC
     * phone number on file.
     */
    public static function sendCampaignPicPaidNotification(Donation $donation): ?array
    {
        $campaign = $donation->campaign;

        if (!$campaign || blank($campaign->telp_pj)) {
            Log::info('[WhatsApp] Skipped PIC paid notification: campaign has no telp_pj', [
                'donation_id' => $donation->id ?? null,
                'campaign_id' => $campaign->id ?? null,
            ]);
            return null;
        }

        $summary = $campaign->getBalanceSummary();

        // telp_pj stores the full number including its country code
        // (e.g. "62877..."), set via the PIC Contact country dropdown —
        // only strip stray non-digit characters, no country-code prefixing needed.
        $picTarget = preg_replace('/[^\d]/', '', $campaign->telp_pj);

        $paidAt = now()->format('d M Y, H:i') . ' WIB';

        // Anonymous donations hide the donor's name from the PIC too — same
        // "Hamba Allah" placeholder used on the public donor list.
        $donorName = $donation->is_anonymous ? 'Hamba Allah' : $donation->nama_donatur;

        // Meta rejects the entire template send if ANY parameter value is
        // empty ("Required parameter is missing", error 131008) — nama_pj is
        // nullable on Campaign (see Campaign::getDistinctPicNames()'s
        // "nama_pj IS NULL" handling), so an empty PIC name here has caused
        // real production sends to silently fail. New campaigns require this
        // field now (see the campaign form), but older existing campaigns
        // may still have it blank — fall back to "PIC {campaign title}"
        // instead of a generic placeholder.
        $picName = $campaign->nama_pj ?: ('PIC ' . $campaign->judul);

        $message = "🔔 *[DONASI MASUK]* 🔔\n\n"
            . "Assalammu'alaikum, {$picName}\n\n"
            . "Alhamdulillah, campaign *{$campaign->judul}* baru saja menerima donasi:\n\n"
            . "👤 *Donatur:* {$donorName}\n"
            . "📱 *Kontak:* " . ($donation->no_telp_donatur ?: '-') . "\n"
            . "📧 *Email:* " . ($donation->email_donatur ?: '-') . "\n"
            . "💰 *Jumlah Donasi:* " . LFC::formatRupiah($donation->jumlah_donasi) . "\n"
            . "💬 *Pesan:* " . ($donation->pesan_donatur ?: '-') . "\n"
            . "🕐 *Waktu:* {$paidAt}\n\n"
            . "📊 *Total Dana Terkumpul (PAID):* " . LFC::formatRupiah($summary['total_paid']) . "\n"
            . "💵 *Saldo Tersedia Saat Ini:* " . LFC::formatRupiah($summary['available']) . "\n\n"
            . "#LDKSyahid\n#CelenganSyahid";

        self::send($picTarget, $message, 'notifikasi_pic_donasi_v2', [
            $picName,
            $campaign->judul,
            $donorName,
            LFC::formatRupiah($donation->jumlah_donasi),
            $paidAt,
            'Total terkumpul ' . LFC::formatRupiah($summary['total_paid']) . ', saldo tersedia ' . LFC::formatRupiah($summary['available']),
        ]);

        return null;
    }

    /**
     * Notify the campaign's PIC (Campaign.telp_pj) whenever a withdrawal is
     * marked COMPLETED. Skips silently (logs info) if the campaign has no
     * PIC phone number on file. Call this AFTER the Withdrawal row's status
     * has been updated to COMPLETED, so getBalanceSummary() reflects the
     * post-withdrawal balance.
     */
    public static function sendCampaignPicWithdrawSuccess(Withdrawal $withdrawal): ?array
    {
        $campaign = $withdrawal->campaign;

        if (!$campaign || blank($campaign->telp_pj)) {
            Log::info('[WhatsApp] Skipped PIC withdraw notification: campaign has no telp_pj', [
                'withdrawal_id' => $withdrawal->id ?? null,
                'campaign_id'   => $campaign->id ?? null,
            ]);
            return null;
        }

        $summary = $campaign->getBalanceSummary();

        $picTarget = preg_replace('/[^\d]/', '', $campaign->telp_pj);

        $picName = $campaign->nama_pj ?: ('PIC ' . $campaign->judul);

        $completedAt = ($withdrawal->completed_at ?? now())->format('d M Y, H:i') . ' WIB';

        $destination = trim($withdrawal->bank_code . ' ' . $withdrawal->account_number . ' a.n. ' . $withdrawal->account_holder);

        $message = "💸 *[WITHDRAW BERHASIL]* 💸\n\n"
            . "Assalammu'alaikum, {$picName}\n\n"
            . "Alhamdulillah, penarikan dana untuk campaign *{$campaign->judul}* telah berhasil diproses:\n\n"
            . "💰 *Jumlah:* " . LFC::formatRupiah($withdrawal->amount) . "\n"
            . "🏦 *Tujuan:* {$destination}\n"
            . "🕐 *Waktu:* {$completedAt}\n\n"
            . "💵 *Saldo Tersedia Saat Ini:* " . LFC::formatRupiah($summary['available']) . "\n\n"
            . "#LDKSyahid\n#CelenganSyahid";

        self::send($picTarget, $message, 'notifikasi_pic_withdraw', [
            $picName,
            $campaign->judul,
            LFC::formatRupiah($withdrawal->amount),
            $destination,
            $completedAt,
            LFC::formatRupiah($summary['available']),
        ]);

        return null;
    }
}
