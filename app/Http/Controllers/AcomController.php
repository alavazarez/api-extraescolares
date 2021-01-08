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
        $response = Acom::with('alumnos')->orderBy('id')->get();
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
        $acom = Acom::select('acoms.id', 'alumnos.name', 'alumnos.matricula','alumnos.carrera', 'alumnos.semestre', 'alumnos.actividad', 'acoms.typeAcom_id', 'acoms.dateDelivery', 'acoms.description')->join('alumnos','acoms.alumno_id','=','alumnos.id')->whereBetween('dateDelivery', [$initialDate, $finalDate])->get();
        return response()->json($acom,200);
    }

    public function exportarAcomsPendientes()
    {
        $acom = Acom::select('acoms.id', 'alumnos.name', 'alumnos.matricula','alumnos.carrera', 'alumnos.semestre', 'alumnos.actividad', 'acoms.typeAcom_id', 'acoms.dateDelivery', 'acoms.description')->join('alumnos','acoms.alumno_id','=','alumnos.id')->where('dateDelivery', null)->get();
        return response()->json($acom,200);
    }
}
