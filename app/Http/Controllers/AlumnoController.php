<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AlumnosExport;


class AlumnoController extends Controller
{
    public function getAlumnos(){
        $alumnos = Alumno::all();
        return response()->json($alumnos);
    }

    public function find($matricula){
        $alumno = Alumno::where('matricula',$matricula)->firstOrFail();
        return response()->json($alumno,200);
    }

    public function exportExcel($id){
        $prueba = Alumno::select('alumnos.name' ,'alumnos.matricula', 'alumnos.carrera', 'alumnos.semestre')->join('alumno_event','alumnos.id','=','alumno_event.alumno_id')->join('events','alumno_event.event_id','=','events.id')->where('events.id', $id)->get();
        return response()->json($prueba,200);
    }
}
