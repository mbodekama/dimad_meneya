<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class setting extends Model
{
    protected $fillable = ['cle','valeur','commentaire'];
}
