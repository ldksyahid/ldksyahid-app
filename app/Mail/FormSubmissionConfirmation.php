<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormSubmissionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  string $formTitle     Title of the form
     * @param  string $respondentName  Name of the respondent (may be empty)
     * @param  array  $answers       Ordered key-value pairs: ['Label' => 'Answer', ...]
     * @param  string $submittedAt   Human-readable submission timestamp
     */
    public function __construct(
        public readonly string $formTitle,
        public readonly string $respondentName,
        public readonly array  $answers,
        public readonly string $submittedAt,
    ) {}

    public function build(): self
    {
        return $this
            ->subject("Konfirmasi Pengisian Formulir: {$this->formTitle}")
            ->view('emails.forms.submission-confirmation');
    }
}
