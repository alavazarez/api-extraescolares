<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    
    protected $fillable = [
        'nameEvent', 
        'type_event_id', 
        'description',
        'date',
        'place',
        'organizer',
    ];

    public function typeEvents()
    {
        return $this->belongsTo('App\Models\TypeEvent','type_event_id', 'id');
    }


    public function scopeEventosDeportivos ($query){
        return $query->where('type_event_id', 1)->count();
    }

    public function scopeEventosCulturales ($query){
        return $query->where('type_event_id', 2)->count();
    }

    public function scopeEventosCivicos ($query){
        return $query->where('type_event_id', 3)->count();
    }

    public function scopeContarAsistencias ($query, $type_event){
        return $query->where('type_event_id', $type_event)
            ->count();
    }
    public function scopeAsistenciaCompletada($query, $event){
        
        $numero_asistencias_por_tipo_evento = $event->numero_asistencias;
        $total_asistencias = $query->contarAsistencias($event->id);

        return $total_asistencias >= $numero_asistencias_por_tipo_evento;
    }

    public function scopeAsistencias ($query) {
        $subquery = $this->eventosDeportivos();
        return $subquery;
    }
    

    public function alumnos()
    {
        return $this->belongsToMany('App\Models\Alumno')->withTimestamps();
    }
}
