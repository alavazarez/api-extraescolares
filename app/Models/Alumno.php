<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    public function acoms()
    {
        return $this->belongsTo('App\Models\Acom');
    }
}


