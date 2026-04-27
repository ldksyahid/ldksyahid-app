<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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
     * Retry per-email jika gagal (SMTP error, dll.) — aman karena hanya 1 penerima.
     */
    public int $tries = 3;

    /**
     * Timeout per pengiriman satu email.
     */
    public int $timeout = 60;

    public function __construct(
        public string   $email,
        public Mailable $mailable,
    ) {}

    public function handle(): void
    {
        Mail::to($this->email)->send($this->mailable);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("[SendSingleMailJob] Gagal kirim ke {$this->email} setelah {$this->tries}x percobaan: " . $exception->getMessage());
    }
}
