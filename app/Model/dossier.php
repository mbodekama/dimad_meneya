<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class dossier extends Model
{
   protected $fillable = ['nomdossier','nbrefichier','ref','session','dateCreation'];
}
