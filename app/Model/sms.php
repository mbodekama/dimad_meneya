<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class sms extends Model
{
    protected $fillable = ['id','code','datesms','titre','descrpt','prix','prixold','liv','msg','img'];
}
