<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeEvent extends Model
{
    protected $table = 'type_events';
    
    protected $fillable = [
        'type',
    ];

    public function events()
    {
        return $this->hasMany('App\Models\Event');
    }
}
