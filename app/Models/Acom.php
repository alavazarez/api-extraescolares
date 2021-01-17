<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acom extends Model
{
    protected $fillable = [
        'alumno_id', 
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
