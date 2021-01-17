<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno_event extends Model
{
    public function events (){
        $this->belongsTo('App\Models\Event');
    }
}
