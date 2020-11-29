<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeEvent extends Model
{
    protected $fillable = [
        'name', 
    ];

    public function events()
    {
        return $this->hasMany('App\Models\Event');
    }
}
