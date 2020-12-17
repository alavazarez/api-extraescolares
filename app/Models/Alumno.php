<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';

    protected $fillable = [
        'name', 
        'matricula', 
        'carrera',
        'semestre',
        'actividad',
        'status',
    ];

    public function acoms()
    {
        return $this->belongsTo('App\Models\Acom');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class)->withTimestamps();
    }
}


