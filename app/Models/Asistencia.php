<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria

class Asistencia extends Model
{
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    
    public function events(){
        return $this->belongsTo('App\Models\Event','event_id','id');
    }

    public function scopeEventosDeportivos ($query){
        return $query->events()
            ->where('type_event_id',1);
    }

    static function getAsistencias($matricula, $type_event){
        return Asistencia::select('asistencias.no_de_control')
            ->join('events','asistencias.event_id','=','events.id')
            ->where('events.type_event_id',$type_event)
            ->where('asistencias.no_de_control', $matricula)
            ->count();
    }
}
