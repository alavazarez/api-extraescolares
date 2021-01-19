<?php

namespace App\Models;

use App\Models\Asistencia;

class Alumno
{
    private $no_de_control;
    private $nombre;

    public function __construct($no_de_control){
        $this->no_de_control = $no_de_control;
    }

    public function getAsistencias(){
        return Asistencia::select('asistencias.no_de_control')
            ->join('events','asistencias.event_id','=','events.id')
            ->where('events.type_event_id',1)
            ->count();
    }

    public function events(){
        $asistencias = $this->getAsistencias();
        foreach($asistencias as $asistencia){
            $asistencia = $asistencia->events()->first();
        }
        return $asistencias;
    }
}
