<?php

namespace App\Helpers;

use GeoIp2\Database\Reader;

/**
 * Detects whether an IP address belongs to a datacenter / cloud provider.
 *
 * Uses MaxMind GeoLite2-ASN.mmdb (same library as GeoIpHelper).
 * Place the database at: storage/app/geoip/GeoLite2-ASN.mmdb
 *
 * Download free at: https://dev.maxmind.com/geoip/geolite2-free-geolocation-data
 * (requires free MaxMind account)
 *
 * If the database file is missing, detection is silently skipped (returns false).
 */
class DatacenterDetector
{
    /** @var Reader|null Singleton reader instance */
    private static ?Reader $reader = null;

    /**
     * Known datacenter / cloud provider ASN numbers.
     * ASN = Autonomous System Number, uniquely identifies a network operator.
     */
    private const DATACENTER_ASNS = [
        // ── Amazon Web Services ──────────────────────────────────────────────
        16509, 14618, 7224, 38895, 8987, 16509,
        // ── Google (Cloud / Infrastructure) ─────────────────────────────────
        15169, 396982, 19527, 36492, 36385, 36384, 36040, 6432,
        // ── Microsoft Azure ──────────────────────────────────────────────────
        8075, 8068, 8069, 3598, 6182,
        // ── Cloudflare ───────────────────────────────────────────────────────
        13335, 209242, 132892,
        // ── DigitalOcean ─────────────────────────────────────────────────────
        14061, 393406,
        // ── Linode / Akamai ──────────────────────────────────────────────────
        63949, 20940, 21342,
        // ── Vultr ────────────────────────────────────────────────────────────
        20473, 64515,
        // ── Hetzner Online ───────────────────────────────────────────────────
        24940, 213230,
        // ── OVH SAS ──────────────────────────────────────────────────────────
        16276, 35540,
        // ── Contabo ──────────────────────────────────────────────────────────
        51167, 40021,
        // ── IBM / SoftLayer ──────────────────────────────────────────────────
        36351, 36352, 19604,
        // ── Oracle Cloud ─────────────────────────────────────────────────────
        31898, 31898, 1286,
        // ── Alibaba Cloud ────────────────────────────────────────────────────
        45102, 37963, 134963, 24429,
        // ── Tencent Cloud ────────────────────────────────────────────────────
        45090, 132203, 132591,
        // ── Fastly ───────────────────────────────────────────────────────────
        54113, 394192,
        // ── Rackspace ────────────────────────────────────────────────────────
        33070, 27357, 10532, 22720, 12200,
        // ── Hurricane Electric ───────────────────────────────────────────────
        6939,
        // ── Leaseweb ─────────────────────────────────────────────────────────
        60781, 28753,
        // ── Choopa / GameServers ─────────────────────────────────────────────
        20473,
        // ── IONOS / 1&1 ──────────────────────────────────────────────────────
        8560, 21100, 198150,
        // ── Scaleway ─────────────────────────────────────────────────────────
        12876, 35903,
        // ── M247 (popular VPN provider hosting) ──────────────────────────────
        9009,
        // ── Worldstream ──────────────────────────────────────────────────────
        49981,
        // ── Censys / Security scanners ───────────────────────────────────────
        398324, 398705,
        // ── Namecheap ────────────────────────────────────────────────────────
        22612, 19318,
        // ── Serverius ────────────────────────────────────────────────────────
        204957, 9009,
        // ── Baidu ────────────────────────────────────────────────────────────
        38365, 55967,
    ];

    /**
     * Keywords in ASN organisation name that strongly indicate a datacenter/cloud.
     * Catches any provider not in the numeric list above.
     */
    private const DATACENTER_KEYWORDS = [
        'amazon',
        'google',
        'microsoft',
        'cloudflare',
        'digitalocean',
        'linode',
        'akamai',
        'vultr',
        'hetzner',
        'ovh',
        'rackspace',
        'ibm cloud',
        'oracle cloud',
        'fastly',
        'leaseweb',
        'scaleway',
        'contabo',
        'hosting',
        'datacenter',
        'data center',
        'data centre',
        'colocation',
        'colo',
        'cloud',
        'server farm',
        'internet exchange',
        'cdn',
        'cdn77',
        'softlayer',
        'dedicated server',
    ];

    /**
     * Returns true if the given IP belongs to a known datacenter or cloud provider.
     * Returns false if the database is missing, IP is private, or on any error.
     */
    public static function isDatacenter(string $ip): bool
    {
        // Skip private / reserved IP ranges (localhost, LAN, etc.)
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return false;
        }

        $dbPath = storage_path('app/geoip/GeoLite2-ASN.mmdb');
        if (!file_exists($dbPath)) {
            return false;
        }

        try {
            if (self::$reader === null) {
                self::$reader = new Reader($dbPath);
            }

            $record = self::$reader->asn($ip);
            $asnNumber = (int) $record->autonomousSystemNumber;
            $asnOrg    = strtolower((string) ($record->autonomousSystemOrganization ?? ''));

            // 1. Check ASN number against known datacenter list
            if (in_array($asnNumber, self::DATACENTER_ASNS, true)) {
                return true;
            }

            // 2. Check ASN org name against keyword list (catches unlisted providers)
            foreach (self::DATACENTER_KEYWORDS as $keyword) {
                if (str_contains($asnOrg, $keyword)) {
                    return true;
                }
            }

            return false;
        } catch (\Throwable) {
            return false;
        }
    }
}
