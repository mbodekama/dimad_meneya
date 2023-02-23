<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class produits_has_ventes_succursales extends Model
{

protected $fillable =["produits_id","ventes_succursales_id","prixvente",'coutAchat', "qte","tva"];
}
