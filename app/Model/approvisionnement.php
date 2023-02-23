<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class approvisionnement extends Model
{
   protected $fillable = ["approvisionMat","succursale_id",'approvisionMontant','	approvisionTotal',"approvisionStatut","dateApro",'charge','description_charge'];

}
