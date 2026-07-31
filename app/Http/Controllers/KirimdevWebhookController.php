<?php

namespace App\Http\Controllers;

use App\Services\Kirimdev;
use App\Services\WhatsAppInboundHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KirimdevWebhookController extends Controller
{
    /**
     * Handle incoming Kirimdev webhook deliveries (Meta Cloud API
     * passthrough + Kirimdev-native events). Signature-verified via
     * Kirimdev::verifyWebhookSignature() — see config/services.php's
     * 'kirimdev.webhook_secrets'. No IP allowlist: Kirimdev's own sending
     * IPs are not published, unlike Bisabiller's, so HMAC signature +
     * throttle is the full defense here (still layered, per the
     * project's callback-endpoint convention).
     */
    public function handle(Request $request, WhatsAppInboundHandler $handler)
    {
        $signatureHeader = $request->header('X-Kirim-Signature', '');
        $rawBody         = $request->getContent();

        if (!Kirimdev::verifyWebhookSignature($signatureHeader, $rawBody)) {
            Log::warning('[Kirimdev Webhook] invalid or missing signature', ['ip' => $request->ip()]);
            return response()->json(['status' => 'unauthorized'], 401);
        }

        $event  = $request->header('X-Kirim-Event', '');
        $source = $request->header('X-Kirim-Source', '');
        $payload = $request->json()->all();

        Log::info('[Kirimdev Webhook] received', ['event' => $event, 'source' => $source]);

        // Meta passthrough — an inbound customer/admin message.
        $messages = data_get($payload, 'entry.0.changes.0.value.messages', []);
        if (!empty($messages)) {
            foreach ($messages as $message) {
                $type = $message['type'] ?? null;

                if ($type === 'text') {
                    $status = $handler->handleReply($message['from'] ?? '', data_get($message, 'text.body', ''));
                    Log::info('[Kirimdev Webhook] inbound text reply processed', ['status' => $status]);
                } elseif ($type === 'button') {
                    // Quick-reply button tap (see request_shortlink_v5 /
                    // Kirimdev::deliver()'s $buttonPayloads) — payload is
                    // whatever string we set when sending, not the button's
                    // display text.
                    $status = $handler->handleButtonReply($message['from'] ?? '', data_get($message, 'button.payload', ''));
                    Log::info('[Kirimdev Webhook] inbound button reply processed', ['status' => $status]);
                }
            }

            return response()->json(['status' => 'ok']);
        }

        // Everything else (message.status delivery receipts, message.sent,
        // conversation.*, contact.*, message.revoked/edited) — no business
        // action wired up yet, just acknowledge so Kirimdev doesn't retry.
        return response()->json(['status' => 'ignored']);
    }
}
