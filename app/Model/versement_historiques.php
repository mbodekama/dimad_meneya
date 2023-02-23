<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class versement_historiques extends Model
{
    protected $fillable=['nomAgent','montantPaye','datePaiement',
'typepaiement','versement_id'];
}
