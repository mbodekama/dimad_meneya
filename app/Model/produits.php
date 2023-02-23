<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class produits extends Model
{
   protected $fillable = ["produitMat","produitLibele","produitPrix","produitPrixFour","description","unite_mesure","categorie_id","seuilAlert",'tva','autre_charge','image'];
}