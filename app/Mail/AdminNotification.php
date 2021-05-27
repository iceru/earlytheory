<?php

namespace App\Mail;

use App\Models\Sales;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminNotification extends Mailable
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
        return $this->from('earlytheory@gmail.com', 'Early Theory')
                    ->to('earlytheory@gmail.com', 'Early Theory')
                    ->subject('Order Masuk ' . $this->sales->sales_no . ' - a/n ' . $this->sales->name)
                    ->view('emails.admin-notification');
    }
}
