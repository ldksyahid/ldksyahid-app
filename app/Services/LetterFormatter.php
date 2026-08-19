<?php

namespace App\Services;

use Carbon\Carbon;

class LetterFormatter
{
    public static function formatWaktu(?string $waktuStr): string
    {
        if (empty($waktuStr)) {
            return '-';
        }

        $waktuStr = trim($waktuStr);
        $formatted = preg_replace('/\s*[-–—]+\s*/u', ' s.d. ', $waktuStr);
        $formatted = preg_replace('/\s*s\.d\.\s*/i', ' s.d. ', $formatted);
        $formatted = preg_replace('/\s+/', ' ', $formatted);

        return trim($formatted);
    }

    public static function formatHariTanggal(?string $dateStr): string
    {
        if (empty($dateStr)) {
            return '-';
        }

        $dateStr = trim($dateStr);

        // Multi-day date range (format: YYYY-MM-DD to YYYY-MM-DD)
        if (preg_match('/^(\d{4}-\d{2}-\d{2})\s*(?:to|s\.d\.|-)\s*(\d{4}-\d{2}-\d{2})$/i', $dateStr, $matches)) {
            try {
                $start = Carbon::parse($matches[1])->locale('id');
                $end   = Carbon::parse($matches[2])->locale('id');

                if ($start->isSameDay($end)) {
                    return $start->translatedFormat('l, d F Y');
                }

                if ($start->format('Y-m') === $end->format('Y-m')) {
                    return $start->translatedFormat('l') . ' – ' . $end->translatedFormat('l') . ', ' . $start->format('d') . ' – ' . $end->translatedFormat('d F Y');
                }

                if ($start->format('Y') === $end->format('Y')) {
                    return $start->translatedFormat('l, d F') . ' – ' . $end->translatedFormat('l, d F Y');
                }

                return $start->translatedFormat('l, d F Y') . ' – ' . $end->translatedFormat('l, d F Y');
            } catch (\Throwable $e) {
                return $dateStr;
            }
        }

        // Single date (format: YYYY-MM-DD)
        try {
            return Carbon::parse($dateStr)->locale('id')->translatedFormat('l, d F Y');
        } catch (\Throwable $e) {
            return $dateStr;
        }
    }
}