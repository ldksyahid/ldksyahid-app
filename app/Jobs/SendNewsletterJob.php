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
     * Number of retry attempts if the job fails.
     */
    public int $tries = 3;

    /**
     * Timeout per job (seconds).
     */
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

        $sent   = 0;
        $failed = 0;

        foreach ($emails as $email) {
            try {
                Mail::to($email)->send(new NewsletterMail($news, $email));
                $sent++;
            } catch (\Throwable $e) {
                $failed++;
                Log::error("[SendNewsletterJob] Failed to send to {$email}: " . $e->getMessage());
            }
        }

        Log::info("[SendNewsletterJob] Newsletter for news ID {$this->newsId} complete. Sent: {$sent}, Failed: {$failed}.");
    }
}
