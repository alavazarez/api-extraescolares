<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\AlumnoModelo;
use App\Enums\EventEnums;
use App\Service\findAlumno;
use App\Http\Resources\AlumnoAsistenciaDeEventos;
use App\Repository\EstudianteRepository;

class AlumnoController extends Controller
{
    protected $estudianteRepository;

    public function __construct() {
        $this->estudianteRepository = new EstudianteRepository ();
    }

    public function exportExcel($id){
        $prueba = AlumnoModelo::select('alumnos.nombre' , 'alumnos.apellidos', 'alumnos.no_de_control', 'alumnos.carrera', 'alumnos.semestre')->join('asistencias', 'alumnos.no_de_control', '=', 'asistencias.no_de_control')->join('events','asistencias.event_id','=','events.id')->where('events.id', $id)->get();
        return response()->json($prueba,200);
    }
    
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
        $alumnoFind = new findAlumno ();

        $asistencias = $alumno->obtenerAsistencias($eventos);
        $alumnoResult = $alumnoFind->find($no_de_control);

        $avance_eventos = new AlumnoAsistenciaDeEventos($alumnoResult,$asistencias);

        return $avance_eventos->toJson();
    }
}
