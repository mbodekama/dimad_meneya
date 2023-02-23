<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class credits extends Model
{
    protected $fillable= ['creditEcheance','creditMontant','creditStatut','creditDate','description','vente_id','sucId'];
}
