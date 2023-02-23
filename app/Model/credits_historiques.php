<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class credits_historiques extends Model
{
    protected $fillable =['montantPaye','datePaiement','typepaiement','credit_id'];
}
