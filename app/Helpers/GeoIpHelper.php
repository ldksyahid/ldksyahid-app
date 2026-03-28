<?php

namespace App\Helpers;

use GeoIp2\Database\Reader;

class GeoIpHelper
{
    private static ?Reader $reader = null;

    /**
     * Lookup country info from an IP address.
     * Returns ['country' => null, 'countryCode' => null] on any failure.
     */
    public static function lookup(string $ip): array
    {
        $empty = ['country' => null, 'countryCode' => null];

        // Skip private/local IPs
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return $empty;
        }

        try {
            if (self::$reader === null) {
                $dbPath = storage_path('app/geoip/GeoLite2-Country.mmdb');
                if (!file_exists($dbPath)) {
                    return $empty;
                }
                self::$reader = new Reader($dbPath);
            }

            $record = self::$reader->country($ip);

            return [
                'country'     => $record->country->name,
                'countryCode' => $record->country->isoCode,
            ];
        } catch (\Throwable $e) {
            return $empty;
        }
    }
}
