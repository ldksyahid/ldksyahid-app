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

/**
 * Dispatcher job: query semua subscriber aktif, lalu dispatch SendSingleMailJob
 * per email sehingga setiap pengiriman berdiri sendiri.
 *
 * Dengan $tries = 1, dispatcher tidak pernah retry — mencegah duplicate dispatch.
 * Retry per-email ditangani oleh SendSingleMailJob ($tries = 3).
 */
class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Tidak perlu retry: jika dispatcher gagal, tidak ada email yang keluar ganda.
     */
    public int $tries = 1;

    public int $timeout = 120;

    public function __construct(public int $newsId) {}

    public function handle(): void
    {
        $news = News::find($this->newsId);

        if (!$news) {
            Log::warning("[SendNewsletterJob] News ID {$this->newsId} not found, job cancelled.");
            return;
        }

        $emails = TrSubscription::where('flagActive', true)->pluck('email');

        if ($emails->isEmpty()) {
            Log::info("[SendNewsletterJob] No active subscribers, job finished.");
            return;
        }

        foreach ($emails as $email) {
            SendSingleMailJob::dispatch($email, new NewsletterMail($news, $email));
        }

        Log::info("[SendNewsletterJob] Dispatched {$emails->count()} individual send jobs for news ID {$this->newsId}.");
    }
}
