<?php

namespace App\Http\Resources;

class AlumnoAsistenciaDeEventos 
{

    private $resource;

    public function __construct( $alumno, $asistencia = null)
    {
        $this->resource = (Object)[
            "alumno" => (Object)[],
            "asistencias" => [],
        ];
        $this->setAlumno($alumno);
        $this->setAsistencia($asistencia);
    }

    private function setAlumno( Object $alumno)
    {
        $this->resource->alumno = $alumno;
    }

    private function setAsistencia(Array $asistencia)
    {
        $this->resource->asistencias = $asistencia;
    }

    public function toJson()
    {
        return json_encode($this->resource);
    }

}
