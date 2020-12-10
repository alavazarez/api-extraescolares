<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function getAlumnos(){
        $alumnos = Alumno::all();
        return response()->json($alumnos);
    }

    public function find($matricula){
        $alumno = Alumno::where('matricula',$matricula)->get();
        return response()->json($alumno);
    }
}
