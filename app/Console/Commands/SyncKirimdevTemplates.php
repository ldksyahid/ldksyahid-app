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
                'name'     => 'invoice_donasi_v2',
                'category' => 'UTILITY',
                'language' => 'id',
                'components' => [
                    [
                        'type' => 'BODY',
                        // Meta rejects a template whose body ends with a variable
                        // ("A variable cannot be at the end of the body") — the
                        // trailing "Terima kasih 😇" after {{5}} is required, not
                        // just cosmetic. Emoji/spacing restored to match the
                        // original Fonnte-era message tone (main branch); the
                        // multi-hashtag + social-media footer block was dropped
                        // on purpose — that combination is what most looks like
                        // marketing content riding on a UTILITY category.
                        'text' => "🚨 *Invoice Donasi* 🚨\n\nAssalamu'alaikum, {{1}} 😊\n\nJazakallah Khairan Katsiiran, kamu berniat berdonasi untuk campaign *{{2}}* sebesar *{{3}}*. Segera selesaikan pembayaran sebelum *{{4}} WIB* melalui link berikut:\n{{5}}\n\nInfo lengkap ada di email kamu ya 😃\n\nTerima kasih telah menjadi bagian dari Manusia Baik 😇",
                        'example' => [
                            'body_text' => [[
                                'Budi', 'Bantu Palestina', 'Rp100.000', '31 Des 2026 23:59', 'https://ldksyah.id/inv/ABC123',
                            ]],
                        ],
                    ],
                ],
            ],
            [
                'name'     => 'donasi_berhasil_v2',
                'category' => 'UTILITY',
                'language' => 'id',
                'components' => [
                    [
                        'type' => 'BODY',
                        'text' => "🎉 *Donasi Berhasil* 🎉\n\nAssalamu'alaikum, {{1}} 😊\n\nAlhamdulillah, donasi kamu sebesar *{{2}}* telah berhasil kami terima. Cek email kamu untuk invoice & status donasinya ya 😁\n\nTerima kasih telah menjadi bagian dari Manusia Baik 😇",
                        'example' => [
                            'body_text' => [['Budi', 'Rp100.000']],
                        ],
                    ],
                ],
            ],
            [
                'name'     => 'notifikasi_pic_donasi_v2',
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
                        'text' => "🔔 *Donasi Masuk* 🔔\n\nAssalamu'alaikum, {{1}}\n\nAlhamdulillah, campaign *{{2}}* baru saja menerima donasi:\n\n👤 Donatur: {{3}}\n💰 Jumlah: {{4}}\n🕐 Waktu: {{5}}\n\n📊 {{6}}.\n\nJazakallah Khairan Katsiiran 🙏",
                        'example' => [
                            'body_text' => [[
                                'Andi', 'Bantu Palestina', 'Budi', 'Rp100.000', '01 Jan 2026, 10:00 WIB', 'Total terkumpul Rp5.000.000, saldo tersedia Rp4.500.000',
                            ]],
                        ],
                    ],
                ],
            ],
            [
                'name'     => 'request_shortlink_v2',
                'category' => 'UTILITY',
                'language' => 'id',
                'components' => [
                    [
                        'type' => 'BODY',
                        // {{1}} (requestId) is renumbered to appear FIRST since
                        // it's the first variable in reading order — Meta
                        // requires variables to appear in ascending numeric
                        // order of first use. Keep WhatsApp::
                        // sendShortlinkRequestNotification()'s param order
                        // (requestId, name, email, whatsapp, customLink) in sync.
                        'text' => "📩 *Request Shortlink #{{1}}* 📩\n\nAda permintaan shortlink baru!\n\n👤 Nama: {{2}}\n📧 Email: {{3}}\n📱 WhatsApp: {{4}}\n✂️ Custom link diminta: {{5}}\n\nBalas *YES* untuk approve atau *NO* untuk tolak permintaan ini.",
                        'example' => [
                            'body_text' => [[
                                '42', 'Budi', 'budi@mail.com', '628123456789', 'ldksyah.id/event2026',
                            ]],
                        ],
                    ],
                ],
            ],
            [
                // Button-based replacement for request_shortlink_v2's typed
                // "YES"/"NO" reply — real WhatsApp quick-reply buttons instead
                // of free-text parsing. Wired into
                // WhatsApp::sendShortlinkRequestNotification() ahead of Meta
                // approval, per explicit user instruction — sends fail/retry
                // via queue backoff until this shows status=approved.
                // v3/v4/v5 (this template's earlier names) were submitted
                // then abandoned/renamed — v3 for a straight rename, v4
                // because it was missing the requester's "Catatan/Keterangan"
                // note (present on the public request form but dropped
                // during the original v2 simplification), v5 because it was
                // missing the original destination link ("Link Asli") the
                // requester wants shortened. All three sit unused on Meta (no
                // delete endpoint via Kirimdev — see kirimdev-whatsapp-migration
                // memory).
                'name'     => 'request_shortlink_v6',
                'category' => 'UTILITY',
                'language' => 'id',
                'components' => [
                    [
                        'type' => 'BODY',
                        'text' => "📩 *Request Shortlink #{{1}}* 📩\n\nAda permintaan shortlink baru!\n\n👤 Nama: {{2}}\n📧 Email: {{3}}\n📱 WhatsApp: {{4}}\n🔗 Link asli: {{5}}\n✂️ Custom link diminta: {{6}}\n📝 Catatan: {{7}}\n\nGunakan tombol di bawah untuk approve atau tolak permintaan ini.",
                        'example' => [
                            'body_text' => [[
                                '42', 'Budi', 'budi@mail.com', '628123456789', 'https://contoh.com/halaman-panjang', 'ldksyah.id/event2026', 'Untuk campaign donasi bulan ini',
                            ]],
                        ],
                    ],
                    [
                        'type' => 'BUTTONS',
                        'buttons' => [
                            ['type' => 'QUICK_REPLY', 'text' => 'Approve'],
                            ['type' => 'QUICK_REPLY', 'text' => 'Reject'],
                        ],
                    ],
                ],
            ],
            [
                'name'     => 'shortlink_disetujui_v2',
                'category' => 'UTILITY',
                'language' => 'id',
                'components' => [
                    [
                        'type' => 'BODY',
                        // Meta rejects reused variable numbers ("Variable {{1}}
                        // is used more than once. Variables must be unique and
                        // sequential.") — each {{n}} may only appear once.
                        'text' => "✅ *Kustom URL Kamu Sudah Jadi* ✅\n\nHalo {{1}} 😀\n\nBerikut hasil link yang telah kami kustom:\n🔗 {{2}}\n\nLink tersebut wajib digunakan sebagaimana mestinya ya. Terima kasih telah menggunakan layanan kami 😉",
                        'example' => [
                            'body_text' => [['Budi', 'https://ldksyah.id/event2026']],
                        ],
                    ],
                ],
            ],
            [
                'name'     => 'shortlink_ditolak_v2',
                'category' => 'UTILITY',
                'language' => 'id',
                'components' => [
                    [
                        'type' => 'BODY',
                        'text' => "❌ *Kustom URL Belum Bisa Diproses* ❌\n\nHalo {{1}} 🙏\n\n✂️ Custom link: {{2}}\n\nMohon maaf, permintaan tersebut belum dapat kami proses saat ini. Silakan hubungi admin untuk info lebih lanjut ya 🙏",
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
