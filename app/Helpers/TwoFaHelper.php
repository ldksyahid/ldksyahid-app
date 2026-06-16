<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use PragmaRX\Google2FA\Google2FA;

class TwoFaHelper
{
    public static function isAllowed(?User $user): bool
    {
        if (!$user) return false;
        if (!$user->hasRole('Superadmin')) return false;

        $allowed = config('services.two_fa.allowed_users', []);
        return in_array($user->email, $allowed);
    }

    public static function generateSecret(): string
    {
        return (new Google2FA())->generateSecretKey();
    }

    public static function qrCodeUrl(User $user, string $secret): string
    {
        $appName = config('services.two_fa.app_name', 'LDK Syahid Admin');
        return (new Google2FA())->getQRCodeUrl($appName, $user->email, $secret);
    }

    public static function renderQrSvg(string $url): string
    {
        $writer = new \BaconQrCode\Writer(
            new \BaconQrCode\Renderer\ImageRenderer(
                new \BaconQrCode\Renderer\RendererStyle\RendererStyle(200),
                new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
            )
        );
        return $writer->writeString($url);
    }

    public static function verify(User $user, string $code): bool
    {
        $rateLimitKey = '2fa_attempts_' . $user->id;
        $attempts     = Cache::get($rateLimitKey, 0);

        if ($attempts >= 5) {
            return false;
        }

        if (!$user->google2fa_enabled || !$user->google2fa_secret) {
            return false;
        }

        $google2fa = new Google2FA();
        $secret    = decrypt($user->google2fa_secret);

        // verifyKeyNewer ensures anti-replay (each TOTP window used only once)
        $timestamp = $google2fa->verifyKeyNewer($secret, $code, $user->two_fa_last_ts, 1);

        if ($timestamp !== false) {
            Cache::forget($rateLimitKey);
            $user->update([
                'two_fa_last_ts'      => $timestamp,
                'two_fa_last_used_at' => now(),
                'two_fa_last_used_ip' => request()->ip(),
            ]);
            return true;
        }

        Cache::put($rateLimitKey, $attempts + 1, now()->addMinutes(5));
        return false;
    }

    public static function rateLimitAttemptsLeft(User $user): int
    {
        $attempts = Cache::get('2fa_attempts_' . $user->id, 0);
        return max(0, 5 - $attempts);
    }
}
