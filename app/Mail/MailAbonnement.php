<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailAbonnement extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $email;
    public $offre;
    public $domaine;
    public $pass;
    public function __construct($email,$offre,$domaine,$pass)
    {
        $this->email = $email ;
        $this->offre = $offre ;
        $this->domaine = $domaine ;
        $this->pass = $pass ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {


        return $this->subject('MENEYA - REABONNEMENT')
                ->from('meneya@noreply.com')
                ->markdown('emails.suscribe.reabonnement');

    }
}
