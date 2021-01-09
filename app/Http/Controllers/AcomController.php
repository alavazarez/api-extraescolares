<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acom;
use Carbon\Carbon;

class AcomController extends Controller
{
    public function store(Request $request, $id)
    {   
        $acom = Acom::where('alumno_id',$id)->count();
        if($acom > 0)
        {
            return response()->json('Ya se genero su ACOM',200);
        }
        else
        {
            Acom::create($request->all());
            return response()->json('Guardado exitoso',200);
        }
    }

    public function getAcoms()
    {
        $response = Acom::select('acoms.id', 'alumnos.matricula', 'alumnos.name', 'alumnos.carrera', 'alumnos.semestre', 'type_Acoms.type', 'acoms.dateDelivery', 'acoms.description', 'acoms.status')->join('alumnos','acoms.alumno_id','=','alumnos.id')->join('type_Acoms','acoms.typeAcom_id','=','type_Acoms.id')->get();
        return response()->json($response, 200);
    }

    public function deliverAcom($id)
    {
        $date = Carbon::now();
        $acom = Acom::find($id);
        $acom->dateDelivery = $date->format('Y-m-d H:i:s');
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
}
