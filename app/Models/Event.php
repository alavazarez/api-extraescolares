<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 
        'type', 
        'date',
        'time',
        'Place',
    ];

    public function typeEvents()
    {
        return $this->belongsTo('App\Models\TypeEvent');
    }
}
