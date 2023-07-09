<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonationInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $campaignName;
    public $linkCampaign;
    public $donaturName;
    public $donaturMessage;
    public $donationAmount;
    public $donationID;
    public $invoiceUrl;
    public $merchantName;
    public $logo;
    public $expiredDate;

    /**
     * Create a new message instance.
     *
     * @param  array  $data
     * @return void
     */
    public function __construct($data)
    {
        $this->campaignName = $data['campaignName'];
        $this->linkCampaign = $data['linkCampaign'];
        $this->donaturName = $data['donaturName'];
        $this->donaturMessage = $data['donaturMessage'];
        $this->donationAmount = $data['donationAmount'];
        $this->donationID = $data['donationID'];
        $this->invoiceUrl = $data['invoiceUrl'];
        $this->merchantName = $data['merchantName'];
        $this->logo = $data['logo'];
        $this->expiredDate = $data['expiredDate'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invoice Donasi')
                    ->view('emails.celengan-syahid.donation-invoice');
    }
}
