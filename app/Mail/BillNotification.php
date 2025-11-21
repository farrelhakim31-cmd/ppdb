<?php

namespace App\Mail;

use App\Models\Bill;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BillNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $bill;

    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
    }

    public function build()
    {
        return $this->subject('Tagihan Pembayaran - ' . $this->bill->description)
                    ->view('emails.bill-notification');
    }
}
