<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

/**
 * Lightweight, dependency-free email deliverability check.
 *
 * Performs two cheap checks before an email is actually sent:
 *   1. RFC syntax validation (filter_var).
 *   2. Domain mail-capability: the domain must publish an MX record
 *      (or, as a fallback, an A/AAAA record per RFC 5321 section 5.1).
 *
 * This does NOT guarantee the individual mailbox exists, but it reliably
 * filters out typos and dead domains so we never waste a send — and our
 * sender reputation — on an address that can never receive mail.
 *
 * Positive domain lookups are cached so common domains (e.g. gmail.com)
 * are not re-queried for every recipient during a bulk newsletter run.
 */
class EmailAddressValidator
{
    /** Cache TTL for a domain's positive mail-capability result, in seconds. */
    private const DOMAIN_CACHE_TTL = 21600; // 6 hours

    /**
     * Return true when the address is well-formed AND its domain can
     * receive mail. When false, $reason is filled with a short label
     * ("invalid_syntax" or "no_mx_record") for logging.
     *
     * @param string      $email
     * @param string|null $reason Out-parameter describing why it failed.
     * @return bool
     */
    public static function isDeliverable(string $email, ?string &$reason = null): bool
    {
        $email = trim($email);

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $reason = 'invalid_syntax';
            return false;
        }

        $domain = self::extractDomain($email);

        if ($domain === null) {
            $reason = 'invalid_syntax';
            return false;
        }

        if (!self::domainCanReceiveMail($domain)) {
            $reason = 'no_mx_record';
            return false;
        }

        $reason = null;
        return true;
    }

    /**
     * Extract the domain part of an email address, or null if absent.
     */
    private static function extractDomain(string $email): ?string
    {
        $at = strrchr($email, '@');

        // strrchr() returns "@domain"; need at least one char after "@".
        if ($at === false || strlen($at) < 2) {
            return null;
        }

        return substr($at, 1);
    }

    /**
     * True if the domain publishes an MX record, or (fallback) an A/AAAA
     * record. Only positive results are cached: a negative lookup may be a
     * transient DNS hiccup, so we let it be re-checked on the next attempt.
     */
    private static function domainCanReceiveMail(string $domain): bool
    {
        $cacheKey = 'mx_check_' . strtolower($domain);

        if (Cache::get($cacheKey) === true) {
            return true;
        }

        // checkdnsrr() returns true when at least one record of the given
        // type exists for the host.
        $canReceive = checkdnsrr($domain, 'MX')
            || checkdnsrr($domain, 'A')
            || checkdnsrr($domain, 'AAAA');

        if ($canReceive) {
            Cache::put($cacheKey, true, self::DOMAIN_CACHE_TTL);
        }

        return $canReceive;
    }
}
