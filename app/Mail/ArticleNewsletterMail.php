<?php

namespace App\Mail;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ArticleNewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public Article $article;
    public string $articleUrl;
    public string $unsubscribeUrl;

    public function __construct(Article $article, string $recipientEmail)
    {
        $this->article        = $article;
        $this->articleUrl     = rtrim(config('app.url'), '/') . $article->getArticleUrl();
        $this->unsubscribeUrl = rtrim(config('app.url'), '/') . '/unsubscribe?email=' . urlencode($recipientEmail);
    }

    public function build()
    {
        return $this->subject('📄 ' . $this->article->title . ' – LDK Syahid')
                    ->view('emails.newsletter.article');
    }
}
