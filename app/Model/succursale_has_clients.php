<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class succursale_has_clients extends Model
{
    protected $fillable =['succursale_id','clients_id'];
}
