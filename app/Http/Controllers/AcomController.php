<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acom;
use App\Models\Alumno;
use Carbon\Carbon;

class AcomController extends Controller
{
    public function store(Request $request, $id)
    {   
        $acom = Acom::where('no_de_control',$id)->count();
        if($acom > 0)
        {
            return response()->json(false,200);
        }
        else
        {
            Acom::create($request->all());
            return response()->json(true,200);
        }
    }

    public function findAcomAlumno($id){
        $find = Acom::where('alumno_id', $id)->count();
        if($find == 1)
        {
            $alumno = Acom::select('acoms.created_at', 'alumnos.name', 'alumnos.matricula', 'alumnos.carrera', 'alumnos.actividad')->join('alumnos', 'acoms.alumno_id','=','alumnos.id')->where('acoms.alumno_id', $id)->get();
            return response()->json($alumno,200);
        }
        else
        {
            return response()->json(false,200);
        }
    }

    public function getAcoms()
    {
        $response = Acom::select('acoms.id', 'type_Acoms.type', 'acoms.dateDelivery', 'acoms.description', 'acoms.status')->join('type_Acoms','acoms.typeAcom_id','=','type_Acoms.id')->get();
        return response()->json($response, 200);
    }

    public function deliverAcom($id)
    {
        $date = Carbon::now();
        $acom = Acom::find($id);
        $acom->dateDelivery = $date->format('Y-m-d H:i:s');
        $acom->status = 1;
        $acom->save();
        return response()->json($acom, 200);
    }

    public function exportarAcomLiberados($initialDate, $finalDate)
    {
        $acom = Acom::select('acoms.id', 'alumnos.name', 'alumnos.matricula','alumnos.carrera', 'alumnos.semestre', 'alumnos.actividad', 'type_acoms.type', 'acoms.dateDelivery', 'acoms.description')->join('alumnos','acoms.alumno_id','=','alumnos.id')->join('type_acoms', 'acoms.typeAcom_id','=','type_acoms.id')->whereBetween('dateDelivery', [$initialDate, $finalDate])->get();
        return response()->json($acom,200);
    }

    public function exportarAcomsPendientes()
    {
        $acom = Acom::select('acoms.id', 'alumnos.name', 'alumnos.matricula','alumnos.carrera', 'alumnos.semestre', 'alumnos.actividad', 'type_acoms.type', 'acoms.dateDelivery', 'acoms.description')->join('alumnos','acoms.alumno_id','=','alumnos.id')->join('type_acoms', 'acoms.typeAcom_id','=','type_acoms.id')->where('dateDelivery', null)->get();
        return response()->json($acom,200);
    }
    public function filtrosAcoms($id){
        if($id == 0)
        {
            $response = Acom::select('acoms.id', 'alumnos.matricula', 'alumnos.name', 'alumnos.carrera', 'alumnos.semestre', 'type_Acoms.type', 'acoms.dateDelivery', 'acoms.description', 'acoms.status')->join('alumnos','acoms.alumno_id','=','alumnos.id')->join('type_Acoms','acoms.typeAcom_id','=','type_Acoms.id')->get();
            return response()->json($response, 200);
        }
        if($id == 1)
        {
            $response = Acom::select('acoms.id', 'alumnos.matricula', 'alumnos.name', 'alumnos.carrera', 'alumnos.semestre', 'type_Acoms.type', 'acoms.dateDelivery', 'acoms.description', 'acoms.status')->join('alumnos','acoms.alumno_id','=','alumnos.id')->join('type_Acoms','acoms.typeAcom_id','=','type_Acoms.id')->where('acoms.dateDelivery','!=', null)->get();
            return response()->json($response, 200);
        }
        if($id == 2)
        {
            $response = Acom::select('acoms.id', 'alumnos.matricula', 'alumnos.name', 'alumnos.carrera', 'alumnos.semestre', 'type_Acoms.type', 'acoms.dateDelivery', 'acoms.description', 'acoms.status')->join('alumnos','acoms.alumno_id','=','alumnos.id')->join('type_Acoms','acoms.typeAcom_id','=','type_Acoms.id')->where('acoms.dateDelivery','=', null)->get();
            return response()->json($response, 200);
        }
    }
}
