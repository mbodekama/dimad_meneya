<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class user_has_acces extends Model
{
    protected $fillable=['user_id','acces_id','status'];
}
