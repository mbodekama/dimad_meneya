<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class paiement extends Model
{
    protected $fillable = ['codepaiement','amount','statuPaiement'];
}
