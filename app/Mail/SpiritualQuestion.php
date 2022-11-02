<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\AdditionalQuestion;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SpiritualQuestion extends Mailable
{
    use Queueable, SerializesModels;
    public $additional;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AdditionalQuestion $additional)
    {
        $this->additional = $additional;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('earlytheorytarot@gmail.com', 'Early Theory')
        ->to('Nanasagalana@gmail.com', 'Nanasagalana@gmail.com')
        ->subject('Form Question('.$this->additional->sales->sales_no . ') - Early Theory')
        ->view('emails.spiritual-question');
    }
}
