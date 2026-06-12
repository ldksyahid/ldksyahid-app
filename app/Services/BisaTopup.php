<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * BisaTopup (Bisabiller backend) Payment Gateway client — QRIS only.
 *
 * Docs (via Postman JSON): https://api.bisabiller.com
 *   POST /api/login                  (form: username, password)        -> data.access_token
 *   POST /api/payment/transaction    (Bearer)                          -> data.qr_code / payment_links
 *   GET  /api/payment/payment-list   (Bearer)                          -> QRIS = payment_id 33
 *   Callback -> POST to our URL: { transaction_id, status_id, signature, ... }
 *
 * Status map: 1/2/13 = PENDING, 3/4 = PAID, 5 = CANCELLED, 6 = REFUND, 14 = FAILED.
 */
class BisaTopup
{
    /** @var array */
    protected $config;

    public function __construct()
    {
        $this->config = config('services.bisatopup');
    }

    public function baseUrl(): string
    {
        return ($this->config['env'] ?? 'dev') === 'live'
            ? rtrim($this->config['base_url_live'], '/')
            : rtrim($this->config['base_url_dev'], '/');
    }

    /**
     * Login and cache the Bearer token (token lives ~3600s; cache 50 min).
     */
    public function token(): ?string
    {
        $cached = Cache::get('bisatopup_token');
        if ($cached) {
            return $cached;
        }

        try {
            $res = Http::asForm()->post($this->baseUrl() . '/api/login', [
                'username' => $this->config['username'],
                'password' => $this->config['password_api'],
            ]);

            if ($res->failed()) {
                Log::error('[BisaTopup] login failed', ['status' => $res->status(), 'body' => $res->body()]);
                return null;
            }

            $token = data_get($res->json(), 'data.access_token');
            if ($token) {
                Cache::put('bisatopup_token', $token, now()->addMinutes(50));
            }
            return $token;
        } catch (\Throwable $e) {
            Log::error('[BisaTopup] login exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a QRIS transaction. Returns the decoded JSON body (or null on error).
     */
    public function createQrisTransaction(array $payload): ?array
    {
        $token = $this->token();
        if (!$token) {
            return null;
        }

        try {
            $res = Http::withToken($token)
                ->acceptJson()
                ->post($this->baseUrl() . '/api/payment/transaction', $payload);

            if ($res->failed()) {
                Log::error('[BisaTopup] createTransaction failed', [
                    'status'         => $res->status(),
                    'body'           => $res->body(),
                    'transaction_id' => $payload['transaction_id'] ?? null,
                ]);
                return null;
            }

            return $res->json();
        } catch (\Throwable $e) {
            Log::error('[BisaTopup] createTransaction exception: ' . $e->getMessage(), [
                'transaction_id' => $payload['transaction_id'] ?? null,
            ]);
            return null;
        }
    }

    /**
     * ⚠️ BEST-GUESS signature — Bisabiller/BisaTopup/AMDigipay docs do NOT publish
     * the exact formula. SHA-256 is confirmed (64-hex sample). If create-transaction
     * is rejected with an "invalid signature" error in DEV, adjust the concatenation
     * here (and keep verifyCallbackSignature() in sync once the real formula is known).
     *
     * Current guess: sha256(username + transaction_id + nominal + password_api)
     */
    public function buildSignature(string $transactionId, int $nominal): string
    {
        $username = (string) ($this->config['username'] ?? '');
        $secret   = (string) ($this->config['password_api'] ?? '');

        return hash('sha256', $username . $transactionId . $nominal . $secret);
    }

    /**
     * ⚠️ BEST-GUESS callback signature verification. The controller logs the raw
     * callback (incl. their signature) so the real formula can be confirmed in DEV.
     */
    public function verifyCallbackSignature(array $data): bool
    {
        $secret   = (string) ($this->config['password_api'] ?? '');
        $expected = hash('sha256',
            (string) ($data['transaction_id'] ?? '') .
            (string) ($data['status_id'] ?? '') .
            (string) ($data['transaction_total'] ?? '') .
            $secret
        );

        return hash_equals($expected, (string) ($data['signature'] ?? ''));
    }

    /**
     * Map a raw gateway status_id to our internal payment_status.
     */
    public static function mapStatus($statusId): string
    {
        switch ((int) $statusId) {
            case 3:
            case 4:
                return 'PAID';
            case 5:
                return 'CANCELLED';
            case 6:
                return 'REFUND';
            case 14:
                return 'FAILED';
            case 1:
            case 2:
            case 13:
            default:
                return 'PENDING';
        }
    }
}
