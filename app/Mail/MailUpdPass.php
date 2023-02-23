<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailUpdPass extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $email;
    public $domaine;
    public $pass;
    public function __construct($email,$domaine,$pass)
    {
        $this->email = $email ;
        $this->domaine = $domaine;
        $this->pass = $pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('MENEYA - PREMIERE CONNEXION')
                ->from('meneya@noreply.com')
                ->markdown('emails.suscribe.updPassMail');
    }
}
