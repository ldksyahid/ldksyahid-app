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
use Illuminate\Support\Facades\Log;

/**
 * Dispatcher job: queries all active subscribers, then dispatches
 * a SendSingleMailJob per email so each send is independent.
 *
 * With $tries = 1, the dispatcher never retries — preventing duplicate dispatch.
 * Per-email retry is handled by SendSingleMailJob.
 */
class SendArticleNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 1;
    public int $timeout = 120;

    public function __construct(public int $articleId) {}

    public function handle(): void
    {
        $article = Article::find($this->articleId);

        if (!$article) {
            Log::warning("[SendArticleNewsletterJob] Article ID {$this->articleId} not found, job cancelled.");
            return;
        }

        $emails = TrSubscription::where('flagActive', true)->pluck('email');

        if ($emails->isEmpty()) {
            Log::info("[SendArticleNewsletterJob] No active subscribers, job finished.");
            return;
        }

        foreach ($emails as $index => $email) {
            $delaySec = (int) floor($index / 10) * 60;

            SendSingleMailJob::dispatch($email, new ArticleNewsletterMail($article, $email))
                ->delay(now()->addSeconds($delaySec));
        }

        Log::info("[SendArticleNewsletterJob] Dispatched {$emails->count()} individual send jobs for article ID {$this->articleId}.");
    }
}
