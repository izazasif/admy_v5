<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $body;
    public $pdf;

    public function __construct($body,$pdf)
    {
        $this->body = $body;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Admy: Invoice')
                    ->from('notification@admybd.com', 'Admy Mail')
                    ->view('emails.invoice')
                    ->attachData($this->pdf,'invoce.pdf',['mime' => 'application/pdf']);
    }
}
