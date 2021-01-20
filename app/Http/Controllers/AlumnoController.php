<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use GuzzleHttp\Client;
use App\Enums\EventEnums;
use Illuminate\Http\Request;
use App\Exports\AlumnosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Repository\EstudianteRepository;


class AlumnoController extends Controller
{
    protected $estudianteRepository;

    public function __construct(EstudianteRepository $estudianteRepository)
    {
        $this->estudianteRepository = $estudianteRepository;
    }

    public function getAlumnos()
    {
        $alumnos = Alumno::all();
        (object)$data = json_decode($alumnos->getBody());
        $collection = collect($data->data);
        return response()->json($alumnos);
    }


    public function find($matricula)
    {
        $alumno = $this->estudianteRepository->find($matricula);
        return response()->json($alumno);
    }

    public function asistencias($no_de_control)
    {
        $events = [
            EventEnums::EVENTO_DEPORTIVO, 
            EventEnums::EVENTO_CULTURAL, 
            EventEnums::EVENTO_CIVICO
        ];
        $alumno = new Alumno($no_de_control);

        $asistencias_to_events = array();

        foreach ($events as $event) {
            $total_de_asistencias_to_event = $alumno->asistenciasTotales($event);
            array_push($asistencias_to_events, $total_de_asistencias_to_event);
        }

        return response()->json($asistencias_to_events, 200);
    }

    //$prueba = Alumno::select('alumnos.id','alumno_event.event_id','events.type_event_id')->join('alumno_event','alumnos.id','=','alumno_event.alumno_id')->join('events', 'alumno_event.event_id','=','events.id')->where('alumnos.id',1)->count()
}
