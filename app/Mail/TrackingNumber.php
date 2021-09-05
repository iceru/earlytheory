<?php

namespace App\Mail;

use App\Models\Sales;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TrackingNumber extends Mailable
{
    use Queueable, SerializesModels;
    public $sales;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Sales $sales)
    {
        $this->sales = $sales;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('earlytheorytarot@gmail.com', 'Early Theory')
        ->to($this->sales->email, $this->sales->name)
        ->subject('Pesanan telah dikirim (' . $this->sales->sales_no . ') - Early Theory')
        ->view('emails.tracking-number');
    }
}
