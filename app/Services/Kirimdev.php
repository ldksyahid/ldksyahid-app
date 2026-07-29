<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Client for api.kirimdev.com — an official Meta WhatsApp Business Cloud
 * API passthrough. Sending a message here only works once that message's
 * Template has been APPROVED by Meta; see
 * App\Console\Commands\SyncKirimdevTemplates for the submission/status flow.
 */
class Kirimdev
{
    /**
     * ONLY called from SendSingleWhatsAppJob::handle() inside the queue
     * worker (when WHATSAPP_PROVIDER=kirimdev) — never call this directly
     * from application code, to stay behind the rate limiter.
     */
    public static function deliver(string $target, string $templateName, array $params): array
    {
        $components = [];
        if (!empty($params)) {
            $components[] = [
                'type'       => 'body',
                'parameters' => array_map(fn ($value) => ['type' => 'text', 'text' => (string) $value], $params),
            ];
        }

        $response = self::request('post', '/' . config('services.kirimdev.phone_number_id') . '/messages', [
            'messaging_product' => 'whatsapp',
            'to'                => self::normalizeTarget($target),
            'type'              => 'template',
            'template'          => [
                'name'       => $templateName,
                'language'   => config('services.kirimdev.template_language'),
                'components' => $components,
            ],
        ]);

        $result = $response->json();

        if (!$response->successful()) {
            Log::error('Kirimdev send failed', [
                'target'   => $target,
                'template' => $templateName,
                'response' => $result,
            ]);

            // Throw so the job actually retries (backoff) and the failure is
            // visible in /admin/job-queue-log, instead of silently vanishing.
            throw new \RuntimeException('Kirimdev API returned HTTP ' . $response->status());
        }

        return $result;
    }

    /**
     * Send a plain freeform text message — only valid within an active
     * Meta 24h customer-service session (i.e. as a reply to a message the
     * customer sent within the last 24h). Used for ad-hoc admin notices
     * that have no fixed Message Template (see WhatsApp::send()'s
     * $templateName === null case) — sending this outside an active
     * session will be rejected by Meta with error 131047.
     */
    public static function deliverText(string $target, string $message): array
    {
        $response = self::request('post', '/' . config('services.kirimdev.phone_number_id') . '/messages', [
            'messaging_product' => 'whatsapp',
            'to'                => self::normalizeTarget($target),
            'type'              => 'text',
            'text'              => ['body' => $message],
        ]);

        $result = $response->json();

        if (!$response->successful()) {
            Log::error('Kirimdev freeform send failed', ['target' => $target, 'response' => $result]);
            throw new \RuntimeException('Kirimdev API returned HTTP ' . $response->status());
        }

        return $result;
    }

    /**
     * Submit a new template for Meta review. $components follows Meta's
     * template component schema, e.g.:
     *   [['type' => 'BODY', 'text' => 'Pesanan {{1}} sedang diproses.',
     *     'example' => ['body_text' => [['A123']]]]]
     * Returns the unwrapped template resource (status=pending on success —
     * approval is async, poll via getTemplateStatus() or syncTemplates()).
     * Kirimdev wraps this endpoint's payload in a top-level 'data' key
     * (confirmed via live response — {"data": {..., "status": "pending"},
     * "request_id": ...}); this unwraps it so callers can read ['status']
     * directly instead of silently getting null from the wrapper.
     */
    public static function createTemplate(string $name, string $category, string $language, array $components): array
    {
        $response = self::request('post', '/' . config('services.kirimdev.phone_number_id') . '/templates', [
            'name'       => $name,
            'category'   => $category,
            'language'   => $language,
            'components' => $components,
        ]);

        if (!$response->successful()) {
            Log::error('Kirimdev template creation failed', ['name' => $name, 'response' => $response->json()]);
            throw new \RuntimeException('Kirimdev API returned HTTP ' . $response->status() . ' creating template ' . $name);
        }

        return $response->json('data', []);
    }

    // Same 'data'-wrapped response shape as createTemplate() — see its
    // docblock. Returns the unwrapped template resource.
    public static function getTemplateStatus(string $name): array
    {
        $response = self::request('get', '/' . config('services.kirimdev.phone_number_id') . '/templates/' . $name);

        if (!$response->successful()) {
            throw new \RuntimeException('Kirimdev API returned HTTP ' . $response->status() . ' fetching template ' . $name);
        }

        return $response->json('data', []);
    }

    /**
     * Ask Kirimdev to poll Meta for the latest status of every submitted
     * template (approved/rejected/pending) — Kirimdev does not push a
     * webhook event for template status changes, so this must be polled.
     */
    public static function syncTemplates(): array
    {
        $response = self::request('post', '/' . config('services.kirimdev.phone_number_id') . '/templates/sync');

        if (!$response->successful()) {
            throw new \RuntimeException('Kirimdev API returned HTTP ' . $response->status() . ' syncing templates');
        }

        return $response->json();
    }

    /**
     * Look up this app's configured phone_number_id in Kirimdev's connected
     * accounts list (GET /accounts?status=all — Kirimdev's equivalent of
     * Meta's own phone-number health, not a WhatsApp-Web QR-pairing
     * session). Returns the matching account (with 'status':
     * connected|disconnected|degraded|onboarding, plus Meta's own
     * 'meta_status'), or null if not found or the request fails.
     */
    public static function getAccountStatus(): ?array
    {
        $response = self::request('get', '/accounts', ['status' => 'all']);

        if (!$response->successful()) {
            return null;
        }

        $phoneNumberId = config('services.kirimdev.phone_number_id');

        foreach ($response->json('data', []) as $account) {
            if (($account['phone_number_id'] ?? null) === $phoneNumberId) {
                return $account;
            }
        }

        return null;
    }

    /**
     * One-time setup call — registers a webhook subscription and returns
     * an `initial_secret` that Kirimdev shows ONLY on this response. Copy
     * it into KIRIMDEV_WEBHOOK_SECRETS immediately; it cannot be retrieved
     * again afterwards (only rotated, which issues a new one).
     */
    public static function createWebhookSubscription(string $url, array $events, string $description = ''): array
    {
        $response = self::request('post', '/webhook_subscriptions', [
            'url'         => $url,
            'events'      => $events,
            'description' => $description,
        ]);

        $result = $response->json();

        if (!$response->successful()) {
            Log::error('Kirimdev webhook subscription failed', ['url' => $url, 'response' => $result]);
            throw new \RuntimeException('Kirimdev API returned HTTP ' . $response->status() . ' creating webhook subscription');
        }

        return $result;
    }

    /**
     * Verify an inbound webhook delivery's `X-Kirim-Signature` header:
     * `t={unix_ts},v1={hex}[,v1={hex}...]` — HMAC-SHA256 of "{t}.{raw_body}",
     * accepted if ANY configured secret matches ANY v1 value (supports
     * secret rotation, where Kirimdev signs with both old+new at once).
     * $rawBody MUST be the exact unparsed request body bytes — re-encoding
     * parsed JSON will not match the signature.
     */
    public static function verifyWebhookSignature(string $signatureHeader, string $rawBody): bool
    {
        $timestamp  = null;
        $signatures = [];

        foreach (explode(',', $signatureHeader) as $part) {
            [$key, $value] = array_pad(explode('=', trim($part), 2), 2, null);
            if ($key === 't') {
                $timestamp = $value;
            } elseif ($key === 'v1' && $value !== null) {
                $signatures[] = $value;
            }
        }

        if ($timestamp === null || empty($signatures) || !ctype_digit($timestamp)) {
            return false;
        }

        // Reject stale/replayed signatures — default tolerance 5 minutes.
        if (abs(time() - (int) $timestamp) > 300) {
            return false;
        }

        $secrets = config('services.kirimdev.webhook_secrets', []);
        if (empty($secrets)) {
            return false;
        }

        $signedString = $timestamp . '.' . $rawBody;

        foreach ($secrets as $secret) {
            $expected = hash_hmac('sha256', $signedString, $secret);
            foreach ($signatures as $received) {
                if (hash_equals($expected, $received)) {
                    return true;
                }
            }
        }

        return false;
    }

    private static function request(string $method, string $path, array $body = [])
    {
        $baseUrl = rtrim(config('services.kirimdev.base_url'), '/');
        $client  = Http::withToken(config('services.kirimdev.api_key'));

        // For GET, $body is sent as the query string (Http::get()'s 2nd arg).
        return $method === 'get' ? $client->get($baseUrl . $path, $body) : $client->post($baseUrl . $path, $body);
    }

    // Normalizes to E.164 with a leading '+', which is what the messages
    // endpoint's `to` field expects (see docs example "+628123456789").
    private static function normalizeTarget(string $target): string
    {
        $normalized = preg_replace('/[^\d]/', '', $target);
        if (substr($normalized, 0, 1) === '0') {
            $normalized = '62' . substr($normalized, 1);
        }

        return '+' . $normalized;
    }
}
