<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscribeConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject('Selamat! Kamu Berhasil Berlangganan Newsletter LDK Syahid 🎉')
                    ->view('emails.subscription.subscribe');
    }
}
