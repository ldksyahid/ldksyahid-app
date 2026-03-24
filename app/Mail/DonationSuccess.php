<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Donation;
use App\Http\Controllers\LibraryFunctionController as LFC;

class DonationSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $donation;
    public $donationAmountFormatted;
    public $totalTagihanFormatted;
    protected $pdfContent;

    public function __construct(Donation $donation, string $pdfContent)
    {
        $this->donation = $donation;
        $this->pdfContent = $pdfContent;

        $this->donationAmountFormatted = LFC::formatRupiah($donation->jumlah_donasi);

        $totalTagihan = (!empty($donation->total_tagihan) && (int) $donation->total_tagihan > 0)
            ? $donation->total_tagihan
            : $donation->jumlah_donasi;
        $this->totalTagihanFormatted = LFC::formatRupiah($totalTagihan);
    }

    public function build()
    {
        return $this->subject('Donasi Berhasil - ' . $this->donation->campaign->judul)
                    ->view('emails.celengan-syahid.donation-success')
                    ->attachData(
                        $this->pdfContent,
                        'Bukti-Donasi-' . $this->donation->id . '.pdf',
                        ['mime' => 'application/pdf']
                    );
    }
}
