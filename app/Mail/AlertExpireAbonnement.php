<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlertExpireAbonnement extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $nbrJrst;
    public $offre;
    public $domaine;


    public function __construct($nbrJrst,$offre,$domaine)
    {
        $this->nbrJrst = $nbrJrst ;
        $this->offre = $offre ;
        $this->domaine = $domaine ;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('MENEYA - EXPIRATION ABONNEMENT')
                ->from('meneya@noreply.com')
                ->markdown('emails.suscribe.expired');
    }
}
