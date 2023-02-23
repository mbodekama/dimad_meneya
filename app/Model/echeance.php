<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class echeance extends Model
{
  protected $fillable = ['echeanceStatut','echeanceMontant','echeanceDate','dateAchat','fournisseurs_id'];
}
