<?php

namespace App\Mail;

use App\Models\News;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public News $news;
    public string $excerpt;
    public string $newsUrl;
    public string $unsubscribeUrl;

    public function __construct(News $news, string $recipientEmail)
    {
        $this->news           = $news;
        $this->excerpt        = self::makeExcerpt($news->body);
        $this->newsUrl        = rtrim(config('app.url'), '/') . $news->getNewsUrl();
        $this->unsubscribeUrl = rtrim(config('app.url'), '/') . '/unsubscribe?email=' . urlencode($recipientEmail);
    }

    public function build()
    {
        return $this->subject('📰 ' . $this->news->title . ' – LDK Syahid')
                    ->view('emails.newsletter.news');
    }

    private static function makeExcerpt(string $body, int $length = 220): string
    {
        $plain = strip_tags($body);
        $plain = preg_replace('/\s+/', ' ', trim($plain));

        return mb_strlen($plain) > $length
            ? mb_substr($plain, 0, $length) . '...'
            : $plain;
    }
}
