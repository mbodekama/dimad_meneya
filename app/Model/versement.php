<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class versement extends Model
{
    protected $fillable = ['versMat','versStatu','versMnt','dateDebut','dateFin','succursale_id','versDate'];
}
