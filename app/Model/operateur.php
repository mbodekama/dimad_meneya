<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class operateur extends Model
{
    protected $fillable = ['operateurMat','operateurNom','operateurContact','operateurLieu','operateurDate'];
}

