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
 * Dispatcher job: query semua subscriber aktif, lalu dispatch SendSingleMailJob
 * per email sehingga setiap pengiriman berdiri sendiri.
 *
 * Dengan $tries = 1, dispatcher tidak pernah retry — mencegah duplicate dispatch.
 * Retry per-email ditangani oleh SendSingleMailJob ($tries = 3).
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

        foreach ($emails as $email) {
            SendSingleMailJob::dispatch($email, new ArticleNewsletterMail($article, $email));
        }

        Log::info("[SendArticleNewsletterJob] Dispatched {$emails->count()} individual send jobs for article ID {$this->articleId}.");
    }
}
