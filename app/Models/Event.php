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
        return $this->belongsTo('App\Models\TypeEvent');
    }

    public function scopeNombreEvento($query, $nombre) {
        return $query->where('nameEvent',$nombre);
    }

    public function scopeEventosDeportivos ($query){
        $num = $query->where('type_event_id', 1)->count();
    }

    public function scopeEventosCulturales ($query){
        return $query->where('type_event_id', 2)->count();
    }

    public function scopeEventosCivicos ($query){
        return $query->where('type_event_id', 3)->count();
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
