<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class produits_has_vente_principales extends Model
{

protected $fillable =["produits_id","vente_principales_id","prixvente", "qte","tva"];
}
