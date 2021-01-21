<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Enums\EventEnums;
use App\Repository\EstudianteRepository;
use App\Http\Resources\AlumnoAsistenciaDeEventos;


class AlumnoController extends Controller
{
    protected $estudianteRepository;

    public function __construct(EstudianteRepository $estudianteRepository)
    {
        $this->estudianteRepository = $estudianteRepository;
    }

    public function find($matricula)
    {
        $alumno = $this->estudianteRepository->find($matricula);
        return response()->json($alumno);
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
