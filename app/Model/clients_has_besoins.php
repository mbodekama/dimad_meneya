<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class clients_has_besoins extends Model
{
   protected $fillable = ['clients_id','besoins_id','dateD'];
    
}
