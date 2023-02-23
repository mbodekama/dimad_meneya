<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class arrivage extends Model
{
   protected $fillable = ['arrivageLibelle','arrivageDate','arrivagePrix','arrivageQte','statut','MatArvg','charge', 'description_charge'];
}
