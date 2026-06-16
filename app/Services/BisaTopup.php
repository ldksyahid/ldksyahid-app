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
            Log::info('[BisaTopup] createTransaction request', [
                'transaction_id' => $payload['transaction_id'] ?? null,
                'payment_id'     => $payload['payment_id'] ?? null,
                'nominal'        => $payload['nominal'] ?? null,
                'username'       => $payload['username'] ?? null,
                'signature'      => $payload['signature'] ?? null,
            ]);

            $res = Http::withToken($token)
                ->acceptJson()
                ->post($this->baseUrl() . '/api/payment/transaction', $payload);

            Log::info('[BisaTopup] createTransaction response', [
                'status'         => $res->status(),
                'body'           => $res->body(),
                'transaction_id' => $payload['transaction_id'] ?? null,
            ]);

            if ($res->failed()) {
                Log::error('[BisaTopup] createTransaction HTTP error', [
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
     * Signature create-transaction: sha256(username + transaction_id)
     */
    public function buildSignature(string $transactionId): string
    {
        $username = (string) ($this->config['username'] ?? '');

        return hash('sha256', $username . $transactionId);
    }

    /**
     * Verify a bank account before disbursement.
     * POST /api/transfer/inquiry → { data.account_holder, data.fee }
     */
    public function inquiryBank(string $bankCode, string $accountNumber): ?array
    {
        $token = $this->token();
        if (!$token) return null;

        try {
            $res = Http::withToken($token)->acceptJson()
                ->post($this->baseUrl() . '/api/transfer/inquiry', [
                    'bank_code'      => $bankCode,
                    'account_number' => $accountNumber,
                ]);

            Log::info('[BisaTopup] inquiryBank', [
                'bank_code' => $bankCode,
                'account'   => $accountNumber,
                'status'    => $res->status(),
                'body'      => $res->body(),
            ]);

            return $res->failed() ? null : $res->json();
        } catch (\Throwable $e) {
            Log::error('[BisaTopup] inquiryBank exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Execute a bank transfer / disbursement.
     * POST /api/transfer/disburstment
     */
    public function disburse(array $payload): ?array
    {
        $token = $this->token();
        if (!$token) return null;

        try {
            Log::info('[BisaTopup] disburse request', [
                'reff_id'        => $payload['reff_id'] ?? null,
                'bank_code'      => $payload['bank_code'] ?? null,
                'account_number' => $payload['account_number'] ?? null,
                'amount'         => $payload['amount'] ?? null,
            ]);

            $res = Http::withToken($token)->acceptJson()
                ->post($this->baseUrl() . '/api/transfer/disburstment', $payload);

            Log::info('[BisaTopup] disburse response', [
                'reff_id' => $payload['reff_id'] ?? null,
                'status'  => $res->status(),
                'body'    => $res->body(),
            ]);

            return $res->failed() ? null : $res->json();
        } catch (\Throwable $e) {
            Log::error('[BisaTopup] disburse exception: ' . $e->getMessage(), [
                'reff_id' => $payload['reff_id'] ?? null,
            ]);
            return null;
        }
    }

    /**
     * Get the current Bisabiller wallet balance.
     * GET /api/account-info → data.wallet.jumlah
     */
    public function walletBalance(): ?int
    {
        $token = $this->token();
        if (!$token) return null;

        try {
            $res = Http::withToken($token)->acceptJson()
                ->get($this->baseUrl() . '/api/account-info');

            return $res->ok()
                ? (int) data_get($res->json(), 'data.wallet.jumlah')
                : null;
        } catch (\Throwable $e) {
            Log::error('[BisaTopup] walletBalance exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get bank list for disbursement (transfer).
     * GET /api/transfer/bank-list
     */
    public function bankList(): array
    {
        $token = $this->token();
        if (!$token) return [];

        try {
            $res = Http::withToken($token)->acceptJson()
                ->get($this->baseUrl() . '/api/transfer/bank-list');

            Log::info('[BisaTopup] bankList', [
                'url'    => $this->baseUrl() . '/api/transfer/bank-list',
                'status' => $res->status(),
                'body'   => substr($res->body(), 0, 1000),
            ]);

            if (!$res->ok()) return [];

            $json = $res->json();

            // Try common response shapes from Bisabiller API
            if (isset($json['data']) && is_array($json['data'])) {
                // { data: [...] }  or  { data: { bank_list: [...] } }
                $data = $json['data'];
                if (isset($data[0])) return $data;                          // flat array
                if (isset($data['bank_list'])) return $data['bank_list'];   // nested
                if (isset($data['data'])) return $data['data'];             // double-wrapped
            }

            // Flat top-level array
            if (isset($json[0])) return $json;

            Log::warning('[BisaTopup] bankList: unrecognised response shape', [
                'keys' => array_keys($json ?? []),
            ]);
            return [];
        } catch (\Throwable $e) {
            Log::error('[BisaTopup] bankList exception: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Signature callback: sha256(username + transaction_id)
     */
    public function verifyCallbackSignature(array $data): bool
    {
        $username = (string) ($this->config['username'] ?? '');
        $expected = hash('sha256', $username . (string) ($data['transaction_id'] ?? ''));

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
