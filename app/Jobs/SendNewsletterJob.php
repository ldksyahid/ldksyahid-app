<?php

namespace App\Jobs;

use App\Mail\NewsletterMail;
use App\Models\News;
use App\Models\TrSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Jumlah percobaan ulang jika job gagal.
     */
    public int $tries = 3;

    /**
     * Timeout per job (detik).
     */
    public int $timeout = 120;

    public function __construct(public int $newsId) {}

    public function handle(): void
    {
        $news = News::find($this->newsId);

        if (!$news) {
            Log::warning("[SendNewsletterJob] News ID {$this->newsId} tidak ditemukan, job dibatalkan.");
            return;
        }

        $emails = TrSubscription::where('flagActive', true)->pluck('email');

        if ($emails->isEmpty()) {
            Log::info("[SendNewsletterJob] Tidak ada subscriber aktif, job selesai.");
            return;
        }

        $sent   = 0;
        $failed = 0;

        foreach ($emails as $email) {
            try {
                Mail::to($email)->send(new NewsletterMail($news, $email));
                $sent++;
            } catch (\Throwable $e) {
                $failed++;
                Log::error("[SendNewsletterJob] Gagal kirim ke {$email}: " . $e->getMessage());
            }
        }

        Log::info("[SendNewsletterJob] Newsletter news ID {$this->newsId} selesai. Terkirim: {$sent}, Gagal: {$failed}.");
    }
}
