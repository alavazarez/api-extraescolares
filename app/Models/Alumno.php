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

    public function getCountDeportivoAttribute($matricula)
    {
        return Alumno::select('alumnos.matricula','events.type_event_id')->join('alumno_event','alumnos.id','=','alumno_event.alumno_id')->where('matricula',$matricula)->join('events','alumno_event.event_id','=','events.id')->where('type_event_id',1)->count();
    }

    public function getCountCulturalAttribute($matricula)
    {
        return Alumno::select('alumnos.matricula','events.type_event_id')->join('alumno_event','alumnos.id','=','alumno_event.alumno_id')->where('matricula',$matricula)->join('events','alumno_event.event_id','=','events.id')->where('type_event_id',2)->count();
    }

    public function getCountCivicoAttribute($matricula)
    {
        return Alumno::select('alumnos.matricula','events.type_event_id')->join('alumno_event','alumnos.id','=','alumno_event.alumno_id')->where('matricula',$matricula)->join('events','alumno_event.event_id','=','events.id')->where('type_event_id',3)->count();
    }
}


