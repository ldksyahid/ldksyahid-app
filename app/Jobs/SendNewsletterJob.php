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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Dispatcher job: queries all active subscribers, then dispatches
 * a SendSingleMailJob per email so each send is independent.
 *
 * Uses a cache lock to prevent duplicate dispatch on retry.
 * Per-email retry is handled by SendSingleMailJob.
 */
class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $timeout = 120;

    public function __construct(public int $newsId) {}

    public function handle(): void
    {
        $lockKey = "newsletter_dispatched_{$this->newsId}";

        if (Cache::has($lockKey)) {
            return;
        }

        $news = News::find($this->newsId);

        if (!$news) {
            Log::error("[SendNewsletterJob] News ID {$this->newsId} not found, job cancelled.");
            return;
        }

        $emails = TrSubscription::where('flagActive', true)->pluck('email');

        if ($emails->isEmpty()) {
            return;
        }

        foreach ($emails as $index => $email) {
            $delaySec = (int) floor($index / 10) * 60;

            SendSingleMailJob::dispatch($email, new NewsletterMail($news, $email))
                ->delay(now()->addSeconds($delaySec));
        }

        Cache::put($lockKey, true, now()->addHours(24));
    }
}
