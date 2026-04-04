<?php

namespace App\Jobs;

use App\Mail\GeneratedEmailMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendGeneratedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $timeout = 120;

    public function __construct(
        public string $subject,
        public string $body,
        public array  $emails,
    ) {}

    public function handle(): void
    {
        $sent   = 0;
        $failed = 0;

        foreach ($this->emails as $email) {
            try {
                Mail::to($email)->send(new GeneratedEmailMail($this->subject, $this->body));
                $sent++;
            } catch (\Throwable $e) {
                $failed++;
                Log::error("[SendGeneratedEmailJob] Failed to send to {$email}: " . $e->getMessage());
            }
        }

        Log::info("[SendGeneratedEmailJob] Subject: \"{$this->subject}\" — Sent: {$sent}, Failed: {$failed}.");
    }
}
