<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigurationAcom extends Model
{
    protected $fillable = [
        'nameBossDAE', 
        'nameCoordinator', 
        'nameBossDSE',
        'slogan'
    ];
}
