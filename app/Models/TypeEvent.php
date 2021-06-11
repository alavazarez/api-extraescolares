<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeEvent extends Model
{
    protected $table = 'type_events';
    
    protected $fillable = [
        'type',
    ];

    public function events()
    {
        return $this->hasMany('App\Models\Event');
    }

    public function scopeAsistenciaCompletada($query, $events){
        $asistencia_completada = true;
        foreach ($events as $event) {
            $asistencias = $query->where('type_event_id', $event['id'])
            ->count(); 
            if($asistencias < $event['numero_asistencias'])
            {
                $asistencia_completada = false;
            }
        }
        return $asistencia_completada;
    }
}
