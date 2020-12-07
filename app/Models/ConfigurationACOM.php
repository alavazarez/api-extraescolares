<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigurationACOM extends Model
{
    protected $fillable = [
        'nameBossDAE', 
        'nameCoordinator', 
        'nameBossDSE',
        'slogan'
    ];
}
