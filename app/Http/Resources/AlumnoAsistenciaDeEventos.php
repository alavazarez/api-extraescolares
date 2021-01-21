<?php

namespace App\Http\Resources;


class AlumnoAsistenciaDeEventos 
{

    private $resource;

    public function __construct( $alumno, $asistencia = null, $isCompleted = false){
       // $this->setEventos($event);
        $this->resource = (Object)[
            "alumno" => (Object)[],
            "asistencias" => (Object)[],
        ];
        $this->setAlumno($alumno);
        $this->setAsistencia($asistencia);
    }

    private function setAlumno($alumno){
        //dd($alumno->nombre);
        $this->resource->alumno = $alumno;
    }

    private function setEventos($eventos){
        $item = (Object) [];
        foreach($eventos as $event){
            $item->id = $event->id;
            $item->type = $event->type;
            $item->date = $event->date;
            $this->resource->events[] = $item;
        }
    }

    private function setAsistencia($asistencia){
        $this->resource->asistencias = $asistencia;
    }

    private function setIsCompleted($isCompleted){
        
    }


    public function toJson()
    {
        return json_encode($this->resource);
    }
}
