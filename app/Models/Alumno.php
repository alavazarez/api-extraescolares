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
    

    /**
     * 
     */
    private function asistenciasTotales($type_event){
        return Asistencia::select('asistencias.no_de_control')
            ->join('events','asistencias.event_id','=','events.id')
            ->where('events.type_event_id',$type_event)
            ->where('asistencias.no_de_control', $this->no_de_control)
            ->count();
    }

    /**
     * Función que se encarga de devolver un true solo si la asistencia al evento 
     * recibido está completada.
     * @param Object $event - Objecto tipo
     */
    private function asistenciaCompletada($event)
    {
        $numero_asistencias_por_tipo_evento = $event->numero_asistencias;
        $total_asistencias = $this->asistenciasTotales($event->id);
        return $total_asistencias >= $numero_asistencias_por_tipo_evento;
    }

    /**
     * Método que se encarga de devolver true si todos los eventos están completados
     *  @param Array $events - Array de objetos que contiene las id del los tipos de evento y el total
     *  de asistencias que necesitan para ser complatados.
     *  @return Boolean
     */
    public function hasAllEventsCompleted($events)
    {
        foreach ($events as $index => $event)
        {
            if (!$this->asistenciaCompletada($event))
                return false;
        }
        return true;
    }
}
