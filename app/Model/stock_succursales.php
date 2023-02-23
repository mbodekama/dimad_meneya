<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class stock_succursales extends Model
{
    protected $fillable = ['stock_Qte','succursale_id','produits_id','sucCoutAchat'];
}
