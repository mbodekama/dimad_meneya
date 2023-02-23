<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class echeancehistorique extends Model
{
      protected $fillable = ['nomAgent','montantPaye','datePaiement','banque','typepaiement','echeance_id'];
}

