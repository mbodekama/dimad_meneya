<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class arrivage_has_produits extends Model
{
    protected $fillable = ["qteproduits","coutachat",'prixvente',"produits_id","arrivage_id",];
}
