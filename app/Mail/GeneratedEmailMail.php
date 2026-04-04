<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GeneratedEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string  $emailSubject,
        public string  $emailBody,
        public array   $attachmentPaths = [],
    ) {}

    public function build()
    {
        $mail = $this->subject($this->emailSubject)
                     ->view('emails.general.send');

        foreach ($this->attachmentPaths as $path) {
            $fullPath = storage_path('app/' . $path);
            if (file_exists($fullPath)) {
                $mail->attach($fullPath);
            }
        }

        return $mail;
    }
}
