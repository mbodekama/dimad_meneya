<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlertInfo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void

     */
    public $liste;
    public $myTitle;
    public function __construct($myTitle = NULL,$liste)
    {
        $this->myTitle = is_null($myTitle) ? "MENEYA - SEUIL STOCK": $myTitle;
        $this->liste = is_null($liste) ? "Aucun produit en seuil d'alerte": $liste;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->subject("MENEYA - SEUIL STOCK")
                ->from('meneya@noreply.com')
                ->markdown('emails.alert.info');
    }
}
