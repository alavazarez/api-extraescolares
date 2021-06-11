<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria

class Acom extends Model
{
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna

    protected $table = 'acoms';

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
