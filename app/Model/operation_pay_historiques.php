<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class operation_pay_historiques extends Model
{
    protected $fillable=['nomAgent','montantPaye','datePaiement','typepaiement','optionOpteur_id'];
}
