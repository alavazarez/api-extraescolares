<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeAcom extends Model
{
    public function acoms()
    {
        return $this->hasMany('App\Models\Acom');
    }
}
