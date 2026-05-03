<?php

namespace App\Http\Controllers;

use App\Constants\SettingKey\Key1;
use App\Constants\SettingKey\Key2;
use App\Models\MsSetting;
use App\Models\MsShortlink;
use App\Models\ReqShortlink;
use App\Services\Fonnte;
use AshAllenDesign\ShortURL\Classes\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FonnteWebhookController extends Controller
{
    /**
     * Handle incoming Fonnte webhook (WhatsApp message received).
     */
    public function handle(Request $request)
    {
        $sender  = $request->input('sender', '');
        $message = strtolower(trim($request->input('message', '')));

        // Normalize sender phone: strip non-digits
        $normalizedSender = preg_replace('/[^0-9]/', '', $sender);

        // Only process if sender is the admin CP phone
        if (!$this->isAdminCp($normalizedSender)) {
            return response()->json(['status' => 'ignored'], 200);
        }

        // Only process YES or NO replies
        if (!in_array($message, ['yes', 'no'], true)) {
            return response()->json(['status' => 'ignored'], 200);
        }

        // Look up pending request for this admin
        $cacheKey = "fonnte_pending_shortlink:{$normalizedSender}";
        $requestId = Cache::get($cacheKey);

        if (!$requestId) {
            Log::info('Fonnte webhook: no pending shortlink request', ['sender' => $sender]);
            return response()->json(['status' => 'no_pending'], 200);
        }

        $reqShortlink = ReqShortlink::find($requestId);

        if (!$reqShortlink) {
            Cache::forget($cacheKey);
            Log::warning('Fonnte webhook: pending request not found in DB', ['id' => $requestId]);
            return response()->json(['status' => 'not_found'], 200);
        }

        // Already processed
        if (!empty($reqShortlink->fixCustomLink)) {
            Cache::forget($cacheKey);
            return response()->json(['status' => 'already_processed'], 200);
        }

        if ($message === 'yes') {
            $this->approveRequest($reqShortlink, $cacheKey);
        } else {
            $this->rejectRequest($reqShortlink, $cacheKey);
        }

        return response()->json(['status' => 'ok'], 200);
    }

    /**
     * Approve shortlink request: create shortlink and notify requester.
     */
    private function approveRequest(ReqShortlink $req, string $cacheKey): void
    {
        $urlKey = $this->extractUrlKey($req->customLink);

        // Check if url_key already exists
        if (MsShortlink::where('url_key', $urlKey)->exists()) {
            Fonnte::send($this->getAdminPhone(), "⚠️ *URL key \"{$urlKey}\" sudah terpakai.* Silahkan proses manual via web panel.");
            Log::warning('Fonnte webhook: url_key conflict', ['url_key' => $urlKey, 'req_id' => $req->id]);
            return;
        }

        try {
            $builder = new Builder();
            $shortURL = $builder
                ->destinationUrl($req->defaultLink)
                ->urlKey($urlKey)
                ->make();

            $shortlinkUrl = config('app.url') . '/' . $urlKey;

            // Update request record
            $req->update(['fixCustomLink' => $shortlinkUrl]);

            // Notify requester
            Fonnte::sendShortlinkApproved([
                'name'         => $req->name,
                'whatsapp'     => $req->whatsapp,
                'shortlinkUrl' => $shortlinkUrl,
                'defaultLink'  => $req->defaultLink,
            ]);

            Cache::forget($cacheKey);

            Log::info('Fonnte webhook: shortlink approved', ['req_id' => $req->id, 'url_key' => $urlKey]);
        } catch (\Exception $e) {
            Fonnte::send($this->getAdminPhone(), "⚠️ *Gagal buat shortlink:* " . $e->getMessage() . "\nSilahkan proses manual via web panel.");
            Log::error('Fonnte webhook: shortlink creation failed', ['req_id' => $req->id, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Reject shortlink request and notify requester.
     */
    private function rejectRequest(ReqShortlink $req, string $cacheKey): void
    {
        Fonnte::sendShortlinkRejected([
            'name'       => $req->name,
            'whatsapp'   => $req->whatsapp,
            'customLink' => $req->customLink,
        ]);

        Cache::forget($cacheKey);

        Log::info('Fonnte webhook: shortlink rejected', ['req_id' => $req->id]);
    }

    /**
     * Extract url_key from customLink input.
     * Handles both full URL ("https://ldksyah.id/event2024") and plain key ("event2024").
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

        // Fallback: treat entire input as url_key
        return trim($customLink, '/ ');
    }

    /**
     * Check if sender is the admin CP phone number.
     */
    private function isAdminCp(string $normalizedSender): bool
    {
        $cpPhone = MsSetting::getSettingValue1(Key1::LAYANAN, Key2::CpShortlink);
        $cpPhone = !empty($cpPhone) ? $cpPhone : '+6281317209305';
        $normalizedCp = preg_replace('/[^0-9]/', '', $cpPhone);

        return $normalizedSender === $normalizedCp;
    }

    /**
     * Get admin CP phone for error notifications.
     */
    private function getAdminPhone(): string
    {
        $cpPhone = MsSetting::getSettingValue1(Key1::LAYANAN, Key2::CpShortlink);
        return !empty($cpPhone) ? $cpPhone : '+6281317209305';
    }
}
