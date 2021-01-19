<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acom extends Model
{
    protected $fillable = [
        'no_de_control', 
        'typeAcom_id', 
        'dateDelivery',
        'description',
        'status',
    ];

    public function typeAcoms()
    {
        return $this->belongsTo('App\Models\typeAcom');
    }
}
