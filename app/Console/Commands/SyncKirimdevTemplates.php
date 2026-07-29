<?php

namespace App\Console\Commands;

use App\Services\Kirimdev;
use Illuminate\Console\Command;

/**
 * Single source of truth for the 6 WhatsApp Message Templates this app
 * needs on Kirimdev/Meta — one per App\Services\WhatsApp::sendXxx() method.
 * Run with --submit to create any that don't exist yet on Kirimdev; run
 * without it to just print each template's current Meta approval status.
 *
 * IMPORTANT: template approval is async and NOT guaranteed. Sending a given
 * message type only works once its template here shows status=approved —
 * until then, App\Jobs\SendSingleWhatsAppJob will fail/retry for that type
 * (see Kirimdev::deliver()).
 *
 * @see \App\Console\Commands\SyncKirimdevTemplates::templates() for the
 * exact param order each sendXxx() method must pass to WhatsApp::send().
 */
class SyncKirimdevTemplates extends Command
{
    protected $signature = 'kirimdev:templates:sync {--submit : Submit any templates below that don\'t exist yet on Kirimdev} {--only= : Only process the template with this exact name}';

    protected $description = 'Submit/check the 6 WhatsApp message templates used by this app against Kirimdev/Meta.';

    /**
     * Keep in exact sync with the $templateParams order passed to
     * WhatsApp::send() from each sendXxx() method — Meta fills {{1}}, {{2}}...
     * positionally, in declaration order, not by name.
     */
    public static function templates(): array
    {
        return [
            [
                'name'     => 'invoice_donasi',
                'category' => 'UTILITY',
                'language' => 'id',
                'components' => [
                    [
                        'type' => 'BODY',
                        // Meta rejects a template whose body ends with a variable
                        // ("A variable cannot be at the end of the body") — the
                        // trailing "Terima kasih." after {{5}} is required, not
                        // just cosmetic.
                        'text' => "Assalamu'alaikum, {{1}}. Terima kasih atas niat baik Anda berdonasi untuk campaign {{2}} sebesar {{3}}. Segera selesaikan pembayaran sebelum {{4}} melalui link berikut: {{5}}. Terima kasih.",
                        'example' => [
                            'body_text' => [[
                                'Budi', 'Bantu Palestina', 'Rp100.000', '31 Des 2026 23:59 WIB', 'https://ldksyah.id/inv/ABC123',
                            ]],
                        ],
                    ],
                ],
            ],
            [
                'name'     => 'donasi_berhasil',
                'category' => 'UTILITY',
                'language' => 'id',
                'components' => [
                    [
                        'type' => 'BODY',
                        'text' => "Assalamu'alaikum, {{1}}. Alhamdulillah, donasi Anda sebesar {{2}} telah berhasil kami terima. Silakan cek email Anda untuk invoice donasi. Terima kasih telah menjadi bagian dari Manusia Baik.",
                        'example' => [
                            'body_text' => [['Budi', 'Rp100.000']],
                        ],
                    ],
                ],
            ],
            [
                'name'     => 'notifikasi_pic_donasi',
                'category' => 'UTILITY',
                'language' => 'id',
                'components' => [
                    [
                        'type' => 'BODY',
                        // Merged total+available into one param (7→6 vars) as a
                        // reasonable simplification — NOT a confirmed fix. This
                        // template was rejected by Meta ("Invalid parameter" on
                        // 'components') at BOTH 7 and 6 variables, and even with
                        // completely different wording — the actual cause turned
                        // out to be the WhatsApp Business account being brand
                        // new (Meta/Kirimdev flags new accounts as higher spam
                        // risk and recommends waiting ~1 week before creating
                        // templates). Retry via `kirimdev:templates:sync --submit`
                        // once the account has aged; revisit this text/variable
                        // count only if it still fails after that.
                        'text' => "Assalamu'alaikum, {{1}}. Campaign {{2}} baru saja menerima donasi dari {{3}} sebesar {{4}} pada {{5}}. Update saldo: {{6}}.",
                        'example' => [
                            'body_text' => [[
                                'Andi', 'Bantu Palestina', 'Budi', 'Rp100.000', '01 Jan 2026, 10:00 WIB', 'Total terkumpul Rp5.000.000, saldo tersedia Rp4.500.000',
                            ]],
                        ],
                    ],
                ],
            ],
            [
                'name'     => 'request_shortlink',
                'category' => 'UTILITY',
                'language' => 'id',
                'components' => [
                    [
                        'type' => 'BODY',
                        'text' => "Ada permintaan shortlink baru dari {{1}} ({{2}}, {{3}}). Custom link yang diminta: {{4}}. Nomor permintaan #{{5}}. Silakan cek panel admin untuk detail dan proses.",
                        'example' => [
                            'body_text' => [[
                                'Budi', 'budi@mail.com', '628123456789', 'ldksyah.id/event2026', '42',
                            ]],
                        ],
                    ],
                ],
            ],
            [
                'name'     => 'shortlink_disetujui',
                'category' => 'UTILITY',
                'language' => 'id',
                'components' => [
                    [
                        'type' => 'BODY',
                        'text' => "Halo {{1}}, link custom Anda sudah jadi: {{2}}. Terima kasih telah menggunakan layanan kami.",
                        'example' => [
                            'body_text' => [['Budi', 'https://ldksyah.id/event2026']],
                        ],
                    ],
                ],
            ],
            [
                'name'     => 'shortlink_ditolak',
                'category' => 'UTILITY',
                'language' => 'id',
                'components' => [
                    [
                        'type' => 'BODY',
                        'text' => "Halo {{1}}, mohon maaf permintaan custom link {{2}} belum dapat kami proses saat ini. Silakan hubungi admin untuk info lebih lanjut.",
                        'example' => [
                            'body_text' => [['Budi', 'event2026']],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function handle(): int
    {
        $submit = (bool) $this->option('submit');
        $only   = $this->option('only');

        $templates = self::templates();
        if ($only !== null) {
            $templates = array_filter($templates, fn ($t) => $t['name'] === $only);
            if (empty($templates)) {
                $this->error("No template named '{$only}' in the catalog.");
                return self::FAILURE;
            }
        }

        foreach ($templates as $template) {
            $status = null;

            try {
                $status = Kirimdev::getTemplateStatus($template['name']);
            } catch (\Throwable $e) {
                $status = null; // not created yet, or lookup failed — treat the same, --submit will attempt creation
            }

            if ($status === null) {
                if (!$submit) {
                    $this->line("<comment>{$template['name']}</comment>: not yet submitted (rerun with --submit)");
                    continue;
                }

                try {
                    $created = Kirimdev::createTemplate($template['name'], $template['category'], $template['language'], $template['components']);
                    $this->info("{$template['name']}: submitted — status " . ($created['status'] ?? 'pending'));
                } catch (\Throwable $e) {
                    $this->error("{$template['name']}: submission failed — " . $e->getMessage());
                }
                continue;
            }

            $this->line("{$template['name']}: " . ($status['status'] ?? 'unknown'));
        }

        return self::SUCCESS;
    }
}
