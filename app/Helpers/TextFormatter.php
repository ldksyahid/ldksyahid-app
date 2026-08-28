<?php

namespace App\Helpers;

class TextFormatter
{
    /**
     * Escape user-supplied text, auto-link bare URLs/domains (with or
     * without a scheme — e.g. "https://...", "www...", or a bare
     * "wa.me/62..." / "ldksyah.id/..." style link), and convert newlines
     * to <br>. Safe to echo with {!! !!} since linking happens on the
     * already-escaped string — no raw HTML from the source text ever
     * reaches the output.
     */
    public static function linkify(?string $raw): string
    {
        if (!$raw) {
            return '';
        }

        $escaped = e($raw);

        // Scheme-prefixed / www. URLs, or a bare "word.word...word.tld[/path]"
        // domain (TLD must be letters-only so things like "1957." or "8.2.12"
        // never match). The lookbehind keeps it from matching mid-word.
        $pattern = '/(https?:\/\/[^\s<>"]+|www\.[^\s<>"]+|(?<![\/\w@])[a-zA-Z0-9][a-zA-Z0-9\-]*(?:\.[a-zA-Z0-9][a-zA-Z0-9\-]*)*\.[a-zA-Z]{2,}(?:\/[^\s<>"]*)?)/';

        $linked = preg_replace_callback($pattern, function (array $m) {
            $url = $m[0];

            // Trailing punctuation almost never belongs to the link itself
            // (e.g. "(wa.me/123)" or "lihat di ldksyah.id/x.") — keep it
            // outside the <a> tag.
            $trail = '';
            while ($url !== '' && strpbrk(substr($url, -1), '.,!?:;)"\'') !== false) {
                $trail = substr($url, -1) . $trail;
                $url   = substr($url, 0, -1);
            }
            if ($url === '') {
                return $m[0];
            }

            $href = preg_match('/^https?:\/\//i', $url) ? $url : 'https://' . $url;

            return '<a href="' . $href . '" target="_blank" rel="noopener noreferrer">' . $url . '</a>' . $trail;
        }, $escaped);

        return nl2br($linked);
    }
}
