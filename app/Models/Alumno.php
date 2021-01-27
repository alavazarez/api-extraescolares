<?php

namespace App\Models;

use App\Models\Asistencia;
use App\Repository\FormacionIntegralRepository;

class Alumno
{
    private $no_de_control;

    public function __construct($no_de_control){
        $this->no_de_control = $no_de_control;
    }
    
    /**
     * Función que se encarga de otener el curso de formación del alumno
     */
    public function obtenerFormacionIntegral()
    {
        $FormacionIntegralRepository = new FormacionIntegralRepository ();
        return $FormacionIntegralRepository->find($this->no_de_control);
    } 
    /**
     * Función que se encarga de obtener las asitencias por los tipo de evenntos
     */
    public function obtenerAsistencias($eventos)
    {
        $total_asistencias = [];
        foreach ($eventos as $evento){
            $asistencias = (Object) [];
            $asistencias->type = $evento->type;
            $asistencias->type_event = $evento->type_event;
            $asistencias->total_asistencia = $this->asistenciasTotales($evento->type_event);
            $total_asistencias[]= $asistencias;
        }
        return $total_asistencias ;
    }

    /**
     * Función que permite contar la asistencia de un alumno a un evento  determinado
     * @param Number $type_event id del tipo de evento a filtrar
     * @return Number Total de asistencias a un evento
     */
    public function asistenciasTotales($type_event){
        return Asistencia::select('asistencias.no_de_control')
            ->join('events','asistencias.event_id','=','events.id')
            ->where('events.type_event_id',$type_event)
            ->where('asistencias.no_de_control', $this->no_de_control)
            ->count();
    }

    /**
     * Función que se encarga de devolver un true solo si la asistencia al evento 
     * recibido está completada.
     * @param Object $event
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
     *  total de asistencias que necesarios para ser complatados.
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

    public function hasFormacionIntegralAcreditada()
    {
       $formacion_integral = $this->obtenerFormacionIntegral();
       return $formacion_integral->acreditado;
    }
    
}
