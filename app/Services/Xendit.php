<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Xendit
{
    public static function postInvoice($external_id, $jumlah_donasi)
    {
        $secret_key = 'Basic '.config('xendit.key_auth');
        $data_request = Http::withHeaders([
            'Authorization' => $secret_key
        ])->post('https://api.xendit.co/v2/invoices', [
            'external_id' => $external_id,
            'amount' => $jumlah_donasi
        ]);
        return $data_request;
    }
}
