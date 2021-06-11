<?php

namespace App\Http\Resources;

class AlumnoAsistenciaDeEventos 
{

    private $resource;

    public function __construct( $alumno, $asistencia, $formacionIntegral)
    {
        $this->resource = (Object)[
            "alumno" => (Object)[],
            "asistencias" => [],
            "formacionIntegral" => (Object)[],
        ];
        $this->setAlumno($alumno);
        $this->setAsistencia($asistencia);
        $this->setFormacionIntegral($formacionIntegral);
    }

    private function setAlumno( Object $alumno)
    {
        $this->resource->alumno = $alumno;
    }
    

    private function setAsistencia(Array $asistencia)
    {
        $this->resource->asistencias = $asistencia;
    }

    private function setFormacionIntegral(Object $formacionIntegral)
    {
        $this->resource->formacionIntegral = $formacionIntegral;
    }

    public function toJson()
    {
        return json_encode($this->resource);
    }

}
