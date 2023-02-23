<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class vente_principales extends Model
{

    protected $fillable=['NumVente','qte','dateV','cout_achat_total','prix_vente_total','mg_benef_brute','mg_benef_rel','charge','description_charge','typevente','clients_id'];

}
