<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ventes_succursales extends Model
{
    protected $fillable=['NumVente','qte','prix','dateV','cout_achat_total','prix_vente_total','mg_benef_brute','mg_benef_rel','charge','description_charge','typevente','succursale_id','clients_id'];
}
