<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GeneratedEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $emailSubject,
        public string $emailBody,
    ) {}

    public function build()
    {
        return $this->subject($this->emailSubject)
                    ->view('emails.general.send');
    }
}
