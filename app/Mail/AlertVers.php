<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlertVers extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $elemnt;
    public $myTitle;
    public function __construct($myTitle = NULL,$elemnt)
    {
        $this->myTitle = is_null($myTitle) ? "MENEYA - SEUIL STOCK": $myTitle;
        $this->elemnt = is_null($elemnt) ? "Aucun produit en seuil d'alerte": $elemnt;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        //Rappel de paiement de versement
        if ($this->myTitle =='Rappel') 
        {
            return $this->subject('MENEYA - RAPPEL VERSEMENT')
                ->from('meneya@noreply.com')
                ->markdown('emails.alert.rappelVers');        
        }

        //Demande de versement
        if ($this->myTitle =='Demande') 
        {
            return $this->subject('MENEYA - VERSEMENT')
                ->from('meneya@noreply.com')
                ->markdown('emails.alert.demandVers');        
        }


        //Paiement  de versement effectue
        if ($this->myTitle =='paiement') 
        {
            return $this->subject('MENEYA - PAIEMENT')
                ->from('meneya@noreply.com')
                ->markdown('emails.alert.payVers');
        }
    }
}
