<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LetterAssetService
{
    public const KOP_IMAGE_URL = 'https://lh3.googleusercontent.com/d/1e0N2_8TIi0B0csz1h1A_aCyPdIiVn8J3';
    public const TTD_SEKJEN_URL = 'https://lh3.googleusercontent.com/d/1ONULC0i5OAs7wFY7ro3DEm__k5C-Q2Ex';

    public static function kopBase64(): ?string
    {
        return static::fetchBase64(self::KOP_IMAGE_URL, 'kop_ldk');
    }

    public static function ttdSekjenBase64(): ?string
    {
        return static::fetchBase64(self::TTD_SEKJEN_URL, 'ttd_sekjen');
    }

    public static function fetchBase64(string $url, string $cacheKey): ?string
    {
        return Cache::remember('asset_img_' . $cacheKey, 86400, function () use ($url, $cacheKey) {
            try {
                $context = stream_context_create([
                    'http' => ['method' => 'GET', 'header' => "User-Agent: Mozilla/5.0\r\n", 'timeout' => 15],
                    'ssl'  => ['verify_peer' => false, 'verify_peer_name' => false]
                ]);
                $data = @file_get_contents($url, false, $context);
                if ($data) {
                    return 'data:image/png;base64,' . base64_encode($data);
                }

                Log::warning("[LetterAssetService] Failed to fetch remote asset: {$cacheKey} from {$url}");
            } catch (\Throwable $e) {
                Log::error("[LetterAssetService] Error fetching asset {$cacheKey}: " . $e->getMessage());
            }

            return null;
        });
    }
}