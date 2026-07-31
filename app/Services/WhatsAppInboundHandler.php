<?php

namespace App\Services;

use App\Constants\SettingKey\Key1;
use App\Constants\SettingKey\Key2;
use App\Models\MsSetting;
use App\Models\MsShortlink;
use App\Models\ReqShortlink;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Inbound-WhatsApp-reply business logic (the admin's YES/NO reply to a
 * shortlink request notification) — used by KirimdevWebhookController.
 * Kept as its own service (rather than inline in the controller) since the
 * approve/reject flow is genuine business logic, not payload parsing.
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

        if (!in_array($message, ['yes', 'no'], true)) {
            return 'ignored';
        }

        return $this->resolveDecision($sender, $message === 'yes');
    }

    /**
     * Quick-reply button tap equivalent of handleReply() — for
     * request_shortlink_v5's Approve/Reject buttons (see
     * KirimdevWebhookController, Kirimdev::deliver()'s $buttonPayloads).
     * $payload is whatever string was set when sending, NOT the button's
     * display text — this app sends lowercase 'approve'/'reject'.
     *
     * @param string $sender  Raw sender phone number, any format (digits get normalized).
     * @param string $payload The tapped button's payload value.
     * @return string One of: 'ignored', 'no_pending', 'not_found', 'already_processed', 'ok'.
     */
    public function handleButtonReply(string $sender, string $payload): string
    {
        $payload = strtolower(trim($payload));

        if (!in_array($payload, ['approve', 'reject'], true)) {
            return 'ignored';
        }

        return $this->resolveDecision($sender, $payload === 'approve');
    }

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

    /**
     * Handles both a full URL ("https://ldksyah.id/event2024") and a plain
     * key ("event2024").
     */
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
}
