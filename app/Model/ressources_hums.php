<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ressources_hums extends Model
{
    protected $fillable = ['ressourcesMat','ressourcesHumMetier','ressourcesHumNom','ressourcesHEmba','ressourcesHContact','ressourcesHumLieu'];
}
