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
    public $notificationLabels = [];

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
        $this->sales->loadMissing(['skus.products', 'user']);
        $this->notificationLabels = $this->getNotificationLabels();

        $labelPrefix = count($this->notificationLabels) > 0
            ? '[' . implode(' / ', $this->notificationLabels) . '] '
            : '';

        return $this->from('earlytheorytarot@gmail.com', 'Early Theory')
                    ->to('earlytheorytarot@gmail.com', 'Early Theory')
                    ->subject($labelPrefix . 'Order Masuk ' . $this->sales->sales_no . ' - a/n ' . $this->sales->user->name)
                    ->view('emails.admin-notification');
    }

    private function getNotificationLabels()
    {
        foreach ($this->sales->skus as $sku) {
            $product = $sku->products;

            if ($product && $product->urgent) {
                return ['URGENT'];
            }
        }

        return [];
    }
}
