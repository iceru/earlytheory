<?php

namespace App\Mail;

use App\Models\Sales;
use App\Models\Workshop;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WorkshopEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $sales;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Sales $sales, $workshops)
    {
        $this->sales = $sales;
        $this->workshops = $workshops;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('earlytheorytarot@gmail.com', 'Early Theory')
        ->to($this->sales->user->email, $this->sales->user->name)
        ->subject('Access Granted - ' . $this->sales->sales_no . ' - Kelas Mejik')
        ->view('emails.access-granted');
    }
}
