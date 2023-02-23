<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailSms extends Mailable
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
    public $sms_mail;
    public $sms_key;
    public $amount;

    public function __construct($email,$domaine,$pass,$sms_mail,$sms_key,$amount)
    {
        $this->email    = $email;
        $this->domaine  = $domaine;
        $this->pass     = $pass;
        $this->sms_mail = $sms_mail;
        $this->sms_key  = $sms_key;
        $this->amount   = $amount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.suscribe.sms');
        return $this->subject('RECHARGEMENT SMS')
                ->from('meneya@noreply.com')
                ->markdown('emails.suscribe.sms');
    }
}
