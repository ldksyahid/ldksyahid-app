<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

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
        $this->subject($this->emailSubject)
            ->view('emails.general.send')
            ->with([
                'body' => $this->emailBody
            ]);

        foreach ($this->attachmentPaths as $path) {
            $fullPath = Storage::path($path);

            if (file_exists($fullPath)) {
                $this->attach($fullPath);
            }
        }

        return $this;
    }
}
