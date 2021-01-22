<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Enums\EventEnums;
use App\Service\findAlumno;
use App\Http\Resources\AlumnoAsistenciaDeEventos;
use App\Repository\EstudianteRepository;

class AlumnoController extends Controller
{
    public function find($matricula)
    {
        $alumno = new findAlumno ();
        $response = $alumno->find($matricula);
        return response()->json($response);
    }

    public function obtenerAvanceDeEventos($no_de_control)
    {
        $eventos  =  [
            (Object)["type_event" => EventEnums::EVENTO_DEPORTIVO, "type" => "Deportivos"], 
            (Object)["type_event" => EventEnums::EVENTO_CULTURAL, "type" => "Culturales"], 
            (Object)["type_event" => EventEnums::EVENTO_CIVICO, "type" => "Cívicos"]
        ];
        $alumno = new Alumno($no_de_control);

        $asistencias = $alumno->obtenerAsistencias($eventos);
        $alumno = $this->estudianteRepository->find($no_de_control);

        $avance_eventos = new AlumnoAsistenciaDeEventos($alumno,$asistencias);

        return $avance_eventos->toJson();
    }
}
