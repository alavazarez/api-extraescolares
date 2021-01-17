<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use GuzzleHttp\Client;
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
    
    public function getAlumnos(){
        $alumnos = Alumno::all();
        (Object)$data = json_decode($alumnos->getBody());
        $collection = collect($data->data);
        return response()->json($alumnos);
    }
    

    public function find($matricula){
       $alumno = $this->estudianteRepository->find($matricula);
       return response()->json($alumno);
    }

    public function exportExcel($id){
        $prueba = Alumno::select('alumnos.name' ,'alumnos.matricula', 'alumnos.carrera', 'alumnos.semestre')->join('alumno_event','alumnos.id','=','alumno_event.alumno_id')->join('events','alumno_event.event_id','=','events.id')->where('events.id', $id)->get();
        return response()->json($prueba,200);
    }

    //$prueba = Alumno::select('alumnos.id','alumno_event.event_id','events.type_event_id')->join('alumno_event','alumnos.id','=','alumno_event.alumno_id')->join('events', 'alumno_event.event_id','=','events.id')->where('alumnos.id',1)->count()
}

