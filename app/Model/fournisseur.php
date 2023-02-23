<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class fournisseur extends Model
{
   protected $fillable = ['fournisseurMat','fournisseurContact','fournisseurNom',
   'fournisseurRespo','fournisseurMail'];
    
}