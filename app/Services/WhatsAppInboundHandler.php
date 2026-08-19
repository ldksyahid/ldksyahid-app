<?php

namespace App\Services;

use App\Constants\SettingKey\Key1;
use App\Constants\SettingKey\Key2;
use App\Models\MsSetting;
use App\Models\MsShortlink;
use App\Models\ReqShortlink;
use App\Models\SuratLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Inbound-WhatsApp-reply business logic:
 * - Admin YES/NO & button reply to Shortlink requests
 * - Admin YES/NO & button reply to Letter requests (Persuratan)
 */
class WhatsAppInboundHandler
{
    /**
     * @param string $sender  Raw sender phone number, any format (digits get normalized).
     * @param string $message Raw message body.
     * @return string One of: 'ignored', 'no_pending', 'not_found', 'already_processed', 'ok'.
     */
    public function handleReply(string $sender, string $message): string
    {
        $message = strtolower(trim($message));

        if (!in_array($message, ['yes', 'no', 'approve', 'reject'], true)) {
            return 'ignored';
        }

        $isApproved       = in_array($message, ['yes', 'approve'], true);
        $normalizedSender = preg_replace('/[^0-9]/', '', $sender);

        // Check active letter pending session
        if ($this->isLetterAdmin($normalizedSender) && Cache::has("whatsapp_pending_letter:{$normalizedSender}")) {
            return $this->resolveLetterDecision($sender, $isApproved);
        }

        // Check active shortlink pending session
        if ($this->isAdminCp($normalizedSender) && Cache::has("whatsapp_pending_shortlink:{$normalizedSender}")) {
            return $this->resolveDecision($sender, $isApproved);
        }

        // Role-based fallback
        if ($this->isLetterAdmin($normalizedSender)) {
            return $this->resolveLetterDecision($sender, $isApproved);
        }

        if ($this->isAdminCp($normalizedSender)) {
            return $this->resolveDecision($sender, $isApproved);
        }

        return 'ignored';
    }

    /**
     * Quick-reply button tap handler.
     *
     * @param string $sender  Raw sender phone number, any format (digits get normalized).
     * @param string $payload The tapped button's payload value.
     * @return string One of: 'ignored', 'no_pending', 'not_found', 'already_processed', 'ok'.
     */
    public function handleButtonReply(string $sender, string $payload): string
    {
        $payload = strtolower(trim($payload));

        if (in_array($payload, ['approve_letter', 'reject_letter'], true)) {
            return $this->resolveLetterDecision($sender, $payload === 'approve_letter');
        }

        if (in_array($payload, ['approve', 'reject'], true)) {
            $normalizedSender = preg_replace('/[^0-9]/', '', $sender);
            if ($this->isLetterAdmin($normalizedSender) && Cache::has("whatsapp_pending_letter:{$normalizedSender}")) {
                return $this->resolveLetterDecision($sender, $payload === 'approve');
            }
            return $this->resolveDecision($sender, $payload === 'approve');
        }

        return 'ignored';
    }

    // =========================================================================
    // 1. SHORTLINK INBOUND DECISION FLOW
    // =========================================================================

    private function resolveDecision(string $sender, bool $approved): string
    {
        $normalizedSender = preg_replace('/[^0-9]/', '', $sender);

        if (!$this->isAdminCp($normalizedSender)) {
            return 'ignored';
        }

        $cacheKey  = "whatsapp_pending_shortlink:{$normalizedSender}";
        $requestId = Cache::get($cacheKey);

        if (!$requestId) {
            return 'no_pending';
        }

        $reqShortlink = ReqShortlink::find($requestId);

        if (!$reqShortlink) {
            Cache::forget($cacheKey);
            Log::error('WhatsApp inbound: pending request not found in DB', ['id' => $requestId]);
            return 'not_found';
        }

        if (!empty($reqShortlink->fixCustomLink)) {
            Cache::forget($cacheKey);
            return 'already_processed';
        }

        if ($approved) {
            $this->approveRequest($reqShortlink, $cacheKey);
        } else {
            $this->rejectRequest($reqShortlink, $cacheKey);
        }

        return 'ok';
    }

    private function notifyAdmin(string $message): void
    {
        WhatsApp::send($this->getAdminPhone(), $message);
    }

    private function approveRequest(ReqShortlink $req, string $cacheKey): void
    {
        $urlKey = $this->extractUrlKey($req->customLink);

        if (MsShortlink::where('url_key', $urlKey)->exists()) {
            $this->notifyAdmin("⚠️ *URL key \"{$urlKey}\" sudah terpakai.* Silahkan proses manual via web panel.");
            Log::error('WhatsApp inbound: url_key conflict', ['url_key' => $urlKey, 'req_id' => $req->id]);
            return;
        }

        try {
            $shortlinkUrl = config('app.url') . '/' . $urlKey;

            MsShortlink::create([
                'destination_url'      => $req->defaultLink,
                'default_short_url'    => $shortlinkUrl,
                'url_key'              => $urlKey,
                'single_use'           => false,
                'track_visits'         => true,
                'redirect_status_code' => 301,
                'created_by'           => 'WhatsApp Webhook',
            ]);

            $req->update(['fixCustomLink' => $shortlinkUrl]);

            WhatsApp::sendShortlinkApproved([
                'name'         => $req->name,
                'whatsapp'     => $req->whatsapp,
                'shortlinkUrl' => $shortlinkUrl,
                'defaultLink'  => $req->defaultLink,
            ]);

            Cache::forget($cacheKey);

            $this->notifyAdmin(
                "✅ *SHORTLINK BERHASIL DIKIRIM*\n\n"
                . "👤 {$req->name}\n"
                . "📱 {$req->whatsapp}\n\n"
                . "🔗 {$shortlinkUrl}\n\n"
                . "Status: Pesan berhasil dikirim ke user."
            );
        } catch (\Exception $e) {
            $this->notifyAdmin(
                "⚠️ *Gagal buat shortlink:* " . $e->getMessage() . "\nSilahkan proses manual via web panel."
            );

            Log::error('WhatsApp inbound: shortlink creation failed', ['req_id' => $req->id, 'error' => $e->getMessage()]);
        }
    }

    private function rejectRequest(ReqShortlink $req, string $cacheKey): void
    {
        WhatsApp::sendShortlinkRejected([
            'name'        => $req->name,
            'whatsapp'    => $req->whatsapp,
            'customLink'  => $req->customLink,
            'defaultLink' => $req->defaultLink,
        ]);

        Cache::forget($cacheKey);

        $this->notifyAdmin(
            "❌ *SHORTLINK DITOLAK & NOTIF TERKIRIM*\n\n"
            . "👤 {$req->name}\n"
            . "📱 {$req->whatsapp}\n\n"
            . "✂️ {$req->customLink}\n\n"
            . "Status: Pesan penolakan berhasil dikirim ke user."
        );
    }

    private function extractUrlKey(string $customLink): string
    {
        $parsed = parse_url(trim($customLink));

        if (isset($parsed['path'])) {
            $path = ltrim($parsed['path'], '/');
            if (!empty($path)) {
                return $path;
            }
        }

        return trim($customLink, '/ ');
    }

    private function isAdminCp(string $normalizedSender): bool
    {
        $cpPhone      = MsSetting::getSettingValue1(Key1::LAYANAN, Key2::CpShortlink);
        $cpPhone      = !empty($cpPhone) ? $cpPhone : '+62895394755672';
        $normalizedCp = preg_replace('/[^0-9]/', '', $cpPhone);

        return $normalizedSender === $normalizedCp;
    }

    private function getAdminPhone(): string
    {
        $cpPhone = MsSetting::getSettingValue1(Key1::LAYANAN, Key2::CpShortlink);
        return !empty($cpPhone) ? $cpPhone : '+62895394755672';
    }

    // =========================================================================
    // 2. LETTER REQUEST (PERSURATAN) INBOUND DECISION FLOW
    // =========================================================================

    public function resolveLetterDecision(string $sender, bool $approved): string
    {
        $normalizedSender = preg_replace('/[^0-9]/', '', $sender);

        if (!$this->isLetterAdmin($normalizedSender)) {
            return 'ignored';
        }

        $cacheKey = "whatsapp_pending_letter:{$normalizedSender}";
        $letterId = Cache::get($cacheKey);

        if (!$letterId) {
            return 'no_pending';
        }

        $suratLog = SuratLog::with('user')->find($letterId);

        if (!$suratLog) {
            Cache::forget($cacheKey);
            Log::error('WhatsApp inbound: pending letter request not found in DB', ['id' => $letterId]);
            return 'not_found';
        }

        if (!$suratLog->isPending()) {
            Cache::forget($cacheKey);
            return 'already_processed';
        }

        if ($approved) {
            $this->approveLetterRequest($suratLog, $cacheKey, $sender);
        } else {
            $this->rejectLetterRequest($suratLog, $cacheKey, $sender);
        }

        return 'ok';
    }

    private function approveLetterRequest(SuratLog $suratLog, string $cacheKey, string $adminPhone): void
    {
        try {
            $kodeBidang = $suratLog->kodeBidangPengaju() ?: 'KST';
            $result     = $suratLog->executeApproval(
                null,
                'Approved via WhatsApp Webhook',
                1,
                $kodeBidang
            );

            if (!$result['success']) {
                $this->notifyLetterAdmin($adminPhone, "⚠️ *Gagal approve permohonan surat #{$suratLog->id}:* format atau urutan penomoran konflik. Silakan proses manual via web panel.");
                Log::error('WhatsApp inbound: letter approval failed', ['letter_id' => $suratLog->id, 'error' => $result['error']]);
                return;
            }

            Cache::forget($cacheKey);

            $applicantName = $suratLog->user?->name ?: ($suratLog->data['nama'] ?? 'Pemohon');
            $downloadUrl   = route('service.persuratan.riwayat');

            $this->notifyLetterAdmin(
                $adminPhone,
                "✅ *SURAT BERHASIL DISETUJUI*\n\n"
                . "📄 *Nomor Surat:* {$suratLog->nomor_surat}\n"
                . "📌 *Jenis Surat:* {$suratLog->label}\n"
                . "👤 *Pemohon:* {$applicantName}\n"
                . "🏢 *Bidang:* {$suratLog->labelBidangPengaju()}\n\n"
                . "Status: Nomor surat resmi telah diterbitkan."
            );

            if (!empty($suratLog->data['whatsapp'])) {
                WhatsApp::sendLetterApproved([
                    'name'         => $applicantName,
                    'targetPhone'  => $suratLog->data['whatsapp'],
                    'letterType'   => $suratLog->label,
                    'letterNumber' => $suratLog->nomor_surat,
                    'downloadUrl'  => $downloadUrl,
                ]);
            }
        } catch (\Throwable $e) {
            $this->notifyLetterAdmin($adminPhone, "⚠️ *Gagal approve surat:* " . $e->getMessage() . "\nSilakan proses manual via web panel.");
            Log::error('WhatsApp inbound: letter approval exception', ['letter_id' => $suratLog->id, 'error' => $e->getMessage()]);
        }
    }

    private function rejectLetterRequest(SuratLog $suratLog, string $cacheKey, string $adminPhone): void
    {
        try {
            $suratLog->update([
                'status'        => 'rejected',
                'catatan_admin' => 'Ditolak via WhatsApp Webhook.',
                'approved_by'   => 1,
                'approved_at'   => now(),
            ]);

            Cache::forget($cacheKey);

            $applicantName = $suratLog->user?->name ?: ($suratLog->data['nama'] ?? 'Pemohon');

            $this->notifyLetterAdmin(
                $adminPhone,
                "❌ *SURAT BERHASIL DITOLAK*\n\n"
                . "📌 *Jenis Surat:* {$suratLog->label}\n"
                . "👤 *Pemohon:* {$applicantName}\n\n"
                . "Status: Permohonan surat telah ditandai ditolak."
            );

            if (!empty($suratLog->data['whatsapp'])) {
                WhatsApp::sendLetterRejected([
                    'name'        => $applicantName,
                    'targetPhone' => $suratLog->data['whatsapp'],
                    'letterType'  => $suratLog->label,
                    'reason'      => 'Ditolak oleh admin Kestari via WhatsApp.',
                ]);
            }
        } catch (\Throwable $e) {
            $this->notifyLetterAdmin($adminPhone, "⚠️ *Gagal tolak surat:* " . $e->getMessage());
            Log::error('WhatsApp inbound: letter reject exception', ['letter_id' => $suratLog->id, 'error' => $e->getMessage()]);
        }
    }

    private function notifyLetterAdmin(string $phone, string $message): void
    {
        WhatsApp::send($phone, $message);
    }

    public function isLetterAdmin(string $normalizedSender): bool
    {
        $kestariPhone = MsSetting::getSettingValue1('Persuratan', 'Kontak Kestari') ?: '6285819353387';
        $sekjenPhone  = MsSetting::getSettingValue1('Persuratan', 'Kontak Sekjen') ?: '6285776923137';

        $normKestari = preg_replace('/[^0-9]/', '', $kestariPhone);
        $normSekjen  = preg_replace('/[^0-9]/', '', $sekjenPhone);

        return in_array($normalizedSender, array_filter([$normKestari, $normSekjen]), true);
    }
}
