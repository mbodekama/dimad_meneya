<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class operation_has_operateurs extends Model
{
       protected $fillable = ['operateurs_id','operations_id','montant','montantrestant','date','depot_init'];
}
