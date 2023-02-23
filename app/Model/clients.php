<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class clients extends Model
{
   protected $fillable = ['nom','contact','lieu','date','statutClt','mail'];   


}
