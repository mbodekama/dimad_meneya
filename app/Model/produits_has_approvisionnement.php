<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class produits_has_approvisionnement extends Model
{
    protected $fillable = ["qteproduits","coutachat","prixvente","produits_id","approvisionnement_id",];

}
