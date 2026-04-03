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
use Illuminate\Support\Facades\Mail;

class SendArticleNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
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

        $sent   = 0;
        $failed = 0;

        foreach ($emails as $email) {
            try {
                Mail::to($email)->send(new ArticleNewsletterMail($article, $email));
                $sent++;
            } catch (\Throwable $e) {
                $failed++;
                Log::error("[SendArticleNewsletterJob] Failed to send to {$email}: " . $e->getMessage());
            }
        }

        Log::info("[SendArticleNewsletterJob] Article ID {$this->articleId} complete. Sent: {$sent}, Failed: {$failed}.");
    }
}
