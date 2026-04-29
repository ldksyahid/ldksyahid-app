<?php

namespace App\Jobs;

use App\Jobs\Middleware\WaitForGmailDailyReset;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Kirim satu email ke satu penerima.
 * Job ini di-dispatch oleh dispatcher jobs (SendNewsletterJob, dll.)
 * sehingga setiap email berdiri sendiri — tidak ada duplicate akibat retry.
 */
class SendSingleMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Jumlah percobaan lebih tinggi agar job dapat bertahan beberapa hari
     * saat Gmail daily limit sedang aktif dan job di-release ke esok hari.
     */
    public int $tries = 10;

    /**
     * Timeout per pengiriman satu email.
     */
    public int $timeout = 60;

    public function __construct(
        public string   $email,
        public Mailable $mailable,
    ) {}

    /**
     * Middleware stack:
     * 1. RateLimited  — batasi 10 email/menit agar tidak kena throttle SMTP
     * 2. WaitForGmailDailyReset — tunda job jika daily limit Gmail sedang aktif
     */
    public function middleware(): array
    {
        return [
            new RateLimited('send-email'),
            new WaitForGmailDailyReset(),
        ];
    }

    /**
     * Tunggu sebelum retry akibat SMTP error sementara (bukan daily limit).
     * Daily limit ditangani oleh WaitForGmailDailyReset middleware.
     */
    public function backoff(): array
    {
        return [30, 60];
    }

    public function handle(): void
    {
        try {
            Mail::to($this->email)->send($this->mailable);
        } catch (\Swift_TransportException $e) {
            if ($this->isGmailDailyLimitError($e)) {
                // Set cache flag selama 24 jam — middleware akan menahan job lain
                $resetAt = now()->addHours(24);
                Cache::put('gmail_daily_limit_exceeded', $resetAt->timestamp, $resetAt);

                // Tunda job ini sampai limit selesai
                $this->release((int) $resetAt->diffInSeconds(now()));
                return;
            }

            // SMTP error lain (koneksi terputus, dll.) — retry normal dengan backoff
            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("[SendSingleMailJob] Gagal kirim ke {$this->email} setelah {$this->tries}x percobaan: " . $exception->getMessage());
    }

    private function isGmailDailyLimitError(\Swift_TransportException $e): bool
    {
        return str_contains($e->getMessage(), '5.4.5')
            || str_contains($e->getMessage(), 'Daily user sending limit');
    }
}
