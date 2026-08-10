<?php

namespace App\Console\Commands;

use App\Services\Kirimdev;
use Illuminate\Console\Command;

/**
 * One-time setup command — registers this app's webhook URL with Kirimdev.
 * Run once per environment (or again after rotating the secret). Kirimdev
 * returns the signing secret ONLY in this response ("initial_secret") — it
 * cannot be retrieved again afterwards, only rotated.
 */
class RegisterKirimdevWebhook extends Command
{
    protected $signature = 'kirimdev:webhook:register {--description=Production handler}';

    protected $description = 'Register this app\'s /webhook/kirimdev URL as a Kirimdev webhook subscription.';

    public function handle(): int
    {
        $url = route('webhook.kirimdev');

        if (!str_starts_with($url, 'https://')) {
            $this->error("Webhook URL must be HTTPS, got: {$url}. Kirimdev rejects non-HTTPS URLs (400 invalid_webhook_url).");
            return self::FAILURE;
        }

        try {
            $result = Kirimdev::createWebhookSubscription($url, [
                'message.received',
                'message.status',
                'message.sent',
            ], (string) $this->option('description'));
        } catch (\Throwable $e) {
            $this->error('Registration failed: ' . $e->getMessage());
            return self::FAILURE;
        }

        $this->info('Webhook subscription created: ' . ($result['id'] ?? '(id not returned)'));
        $this->warn('COPY THIS SECRET NOW — Kirimdev will not show it again:');
        $this->line($result['initial_secret'] ?? '(secret not returned — check the raw response)');
        $this->line('Add it to KIRIMDEV_WEBHOOK_SECRETS in .env, then restart the queue worker / clear config cache.');

        return self::SUCCESS;
    }
}
