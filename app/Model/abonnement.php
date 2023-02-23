<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class abonnement extends Model
{
    protected $fillable = ['dateDebut','dateFin','statuPaiement','codepaiement','offres_id'];
}
