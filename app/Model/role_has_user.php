<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class role_has_user extends Model
{
    protected $fillable=['roles_id','user_id'];
}
