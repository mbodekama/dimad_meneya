<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class document extends Model
{
    protected $fillable = ['titre','commentaire','joint','ref','session','dossier_id'];
}
