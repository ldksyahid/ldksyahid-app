<?php

namespace App\Jobs;

use App\Mail\ArticleNewsletterMail;
use App\Models\Article;
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
class SendArticleNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $timeout = 120;

    public function __construct(public int $articleId) {}

    public function handle(): void
    {
        $lockKey = "article_newsletter_dispatched_{$this->articleId}";

        if (Cache::has($lockKey)) {
            return;
        }

        $article = Article::find($this->articleId);

        if (!$article) {
            Log::error("[SendArticleNewsletterJob] Article ID {$this->articleId} not found, job cancelled.");
            return;
        }

        $emails = TrSubscription::where('flagActive', true)->pluck('email');

        if ($emails->isEmpty()) {
            return;
        }

        foreach ($emails as $index => $email) {
            $delaySec = (int) floor($index / 10) * 60;

            SendSingleMailJob::dispatch($email, new ArticleNewsletterMail($article, $email))
                ->delay(now()->addSeconds($delaySec));
        }

        Cache::put($lockKey, true, now()->addHours(24));
    }
}
