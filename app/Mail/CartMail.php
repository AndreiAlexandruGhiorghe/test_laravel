<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CartMail extends Mailable
{
    use Queueable, SerializesModels;


    public $productsList;
    public $myCart;
    public $orderDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($productsList, $myCart, $orderDetails)
    {
        $this->productsList = $productsList;
        $this->myCart = $myCart;
        $this->orderDetails = $orderDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.cart_mail');
    }
}
