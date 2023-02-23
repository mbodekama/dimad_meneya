<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class succursale extends Model
{
	protected $fillable = ['succursaleMat','succursaleLibelle','succursalLieu','succursalContact','datesucu','user_id'];


}
