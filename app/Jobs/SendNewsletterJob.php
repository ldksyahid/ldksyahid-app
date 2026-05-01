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
 * Dispatcher job: queries all active subscribers, then dispatches
 * a SendSingleMailJob per email so each send is independent.
 *
 * With $tries = 1, the dispatcher never retries — preventing duplicate dispatch.
 * Per-email retry is handled by SendSingleMailJob.
 */
class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * No retry needed: if the dispatcher fails, no duplicate emails are sent.
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

        foreach ($emails as $index => $email) {
            // Staggered delay: 10 emails per minute (matching rate limiter)
            // Batch 0 → 0s, batch 1 → 60s, etc.
            $delaySec = (int) floor($index / 10) * 60;

            SendSingleMailJob::dispatch($email, new NewsletterMail($news, $email))
                ->delay(now()->addSeconds($delaySec));
        }

        Log::info("[SendNewsletterJob] Dispatched {$emails->count()} individual send jobs for news ID {$this->newsId}.");
    }
}
