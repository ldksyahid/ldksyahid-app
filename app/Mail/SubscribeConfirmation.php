<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscribeConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public string $email;
    public bool $isResubscribe;

    public function __construct(string $email, bool $isResubscribe = false)
    {
        $this->email         = $email;
        $this->isResubscribe = $isResubscribe;
    }

    public function build()
    {
        $subject = $this->isResubscribe
            ? 'Selamat Datang Kembali! Kamu Berhasil Berlangganan Kembali 🎉'
            : 'Selamat! Kamu Berhasil Berlangganan LDK Syahid 🎉';

        return $this->subject($subject)
                    ->view('emails.subscription.subscribe');
    }
}
