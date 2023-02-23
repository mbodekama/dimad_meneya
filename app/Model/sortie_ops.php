<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class sortie_ops extends Model
{
    protected $fillable= ["matSortie","libelleSortie","option_opteur_id", "montantS","quantiteS",'dateSortie','operationsOperateurs_id','charges','tva','chargesDesc'];
}
