<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Xendit
{
    public static function postInvoice($external_id, $jumlah_donasi)
    {
        try {
            $secret_key = 'Basic ' . config('xendit.key_auth');
            $response = Http::withHeaders([
                'Authorization' => $secret_key
            ])->post('https://api.xendit.co/v2/invoices', [
                'external_id' => $external_id,
                'amount'      => $jumlah_donasi,
            ]);

            if ($response->failed()) {
                Log::error('[Xendit] postInvoice HTTP error', [
                    'external_id' => $external_id,
                    'status'      => $response->status(),
                    'body'        => $response->body(),
                ]);
            }

            return $response;
        } catch (\Throwable $e) {
            Log::error('[Xendit] postInvoice exception: ' . $e->getMessage(), [
                'external_id' => $external_id,
            ]);
            throw $e;
        }
    }
}
