<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FordataController extends Controller
{
    /**
     * URL Web App Google Apps Script (Deployment /exec)
     */
    protected string $appsScriptUrl = 'https://script.google.com/macros/s/AKfycbxFpd9IxvBntruI7sOrnJdZis2eyWEBte3F4dH-JG_GaIdsmFLlQKRsrlrNL7t6vdMK/exec';

    /**
     * Display the FORDATA landing page portal.
     */
    public function index()
    {
        $data = [
            'judulWebsite'        => 'FORDATA 2 - LDK Syahid',
            'sekarangFordata'     => '#2 2026',
            'logoWebsite'         => 'https://i.ibb.co.com/mYMhQNQ/FORDATA-8.png',
            'gambarHeaderPusat'   => 'https://i.ibb.co.com/mYMhQNQ/FORDATA-8.png',
            'gambarHeaderCSI'     => 'https://i.ibb.co.com/N6yYBTG0/Screenshot-2026-11-01-172202.png',
            'kontakAdminPusat'    => '6285779446994',
            'kontakAdminCSI'      => '6285814010759',
            'linkFordata'         => url('/fordata'),
            'teksShareFordata'    => "Assalamu'alaikum, gais\nYuk isi FORDATA " . url('/fordata'),
            'linkGformPusat'      => 'https://docs.google.com/forms/d/e/1FAIpQLSezmiBcSHpNpyHJ9FyjzeJAtjwhsNCfhYXueF3VKKvs_tMJ6A/viewform?usp=pp_url',
            'linkGformCSI'        => 'https://docs.google.com/forms/d/e/1FAIpQLSfuO3WOh_RqzW5-2U0PpycNzoyqds5302I5WDc12w5o9r6fgg/viewform?usp=pp_url',
        ];

        return view('landing-page.fordata.index', $data);
    }

    /**
     * Proxy verification request to Google Apps Script.
     * Replaces the legacy appscript.php proxy script.
     */
    public function check(Request $request)
    {
        $nim = trim($request->input('nim', ''));
        $ultah = trim($request->input('ultah', ''));
        $exportnim = $request->input('exportnim', '{}');
        $anakmana = $request->input('anakmana', 'pusat');
        $callback = $request->input('callback', '');

        if (empty($nim) || empty($ultah)) {
            $errorData = [
                'ui' => 'awalan',
                'teks' => 'NIM dan Tanggal Lahir wajib diisi.',
                'link' => '',
            ];
            return $this->formatOutput($errorData, $callback);
        }

        try {
            $response = Http::timeout(120)->get($this->appsScriptUrl, [
                'callback'  => 'antiredir',
                'nim'       => $nim,
                'ultah'     => $ultah,
                'exportnim' => is_string($exportnim) ? $exportnim : json_encode($exportnim),
                'anakmana'  => $anakmana,
            ]);

            if ($response->successful()) {
                $rawBody = trim($response->body());

                // Parse JSON inside antiredir(...)
                if (preg_match('/^antiredir\((.*)\)\s*;?$/s', $rawBody, $matches)) {
                    $parsed = json_decode($matches[1], true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        return $this->formatOutput($parsed, $callback);
                    }
                }

                // If upstream returns plain text or raw response
                return response($rawBody, 200, [
                    'Content-Type' => 'application/javascript; charset=utf-8',
                ]);
            }

            Log::error('FORDATA Apps Script upstream error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            $fallback = [
                'ui'   => 'awalan',
                'teks' => 'Afwan, server sedang sibuk. Silahkan coba beberapa saat lagi atau kontak panitia.',
                'link' => '',
            ];
            return $this->formatOutput($fallback, $callback, 502);

        } catch (\Throwable $e) {
            Log::error('FORDATA proxy exception: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            $fallback = [
                'ui'   => 'awalan',
                'teks' => 'Terjadi kendala koneksi ke database. Silahkan kontak panitia.',
                'link' => '',
            ];
            return $this->formatOutput($fallback, $callback, 500);
        }
    }

    /**
     * Helper to return either JSONP or standard JSON response.
     */
    protected function formatOutput(array $data, string $callback = '', int $status = 200)
    {
        if (!empty($callback)) {
            return response($callback . '(' . json_encode($data) . ');', $status, [
                'Content-Type' => 'application/javascript; charset=utf-8',
            ]);
        }

        return response()->json($data, $status);
    }
}

