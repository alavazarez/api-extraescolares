<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 
        'type_event_id', 
        'description',
        'date',
        'place',
        'organizer',
    ];

    public function typeEvents()
    {
        return $this->belongsTo('App\Models\TypeEvent');
    }
}
