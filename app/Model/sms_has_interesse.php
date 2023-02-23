<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class sms_has_interesse extends Model
{
   protected $fillable = ['sms_id','interesse_id','qte','montant','code','statut','etat','dateCmd'];
}
