<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acom;
use App\Models\ConfigurationAcom;
use Carbon\Carbon;
use App\Models\AlumnoModelo;
use App\Exceptions\Handler;
use App\Http\Controllers\Exception;
use Exception as GlobalException;
use FFI\Exception as FFIException;

class AcomController extends Controller
{
    public function store(Request $request, $id)
    {
        $acom = Acom::where('no_de_control', $id)->count();
        if ($acom > 0) {
            return response()->json(false, 200);
        } else {
            Acom::create($request->all());
            return response()->json(true, 200);
        }
    }

    public function findAcomAlumno($id)
    {
        $find = Acom::where('no_de_control', $id)->exists();
        if ($find == true) {
            $alumno = Acom::select('acoms.created_at')->where('acoms.no_de_control', $id)->get();
            return response()->json($alumno, 200);
        } else {
            return response()->json(false, 200);
        }
    }

    public function getAcoms()
    {
        $response = AlumnoModelo::select('alumnos.no_de_control', 'alumnos.nombre', 'alumnos.apellidos', 'alumnos.carrera', 'alumnos.semestre', 'acoms.id', 'type_Acoms.type', 'acoms.dateDelivery', 'acoms.description', 'acoms.status')->join('acoms', 'alumnos.no_de_control', '=', 'acoms.no_de_control')->join('type_Acoms', 'acoms.typeAcom_id', '=', 'type_Acoms.id')->get();
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
        $acom = Acom::select('acoms.id', 'alumnos.nombre', 'alumnos.apellidos', 'alumnos.sexo', 'alumnos.no_de_control', 'alumnos.carrera', 'alumnos.semestre', 'type_acoms.type', 'acoms.dateDelivery', 'acoms.description')->join('alumnos', 'acoms.no_de_control', '=', 'alumnos.no_de_control')->join('type_acoms', 'acoms.typeAcom_id', '=', 'type_acoms.id')->whereBetween('dateDelivery', [$initialDate, $finalDate])->get();
        return response()->json($acom, 200);
    }

    public function exportarAcomsPendientes()
    {
        $acom = Acom::select('acoms.id', 'alumnos.nombre', 'alumnos.apellidos', 'alumnos.sexo', 'alumnos.no_de_control', 'alumnos.carrera', 'alumnos.semestre', 'type_acoms.type', 'acoms.dateDelivery', 'acoms.description')->join('alumnos', 'acoms.no_de_control', '=', 'alumnos.no_de_control')->join('type_acoms', 'acoms.typeAcom_id', '=', 'type_acoms.id')->where('dateDelivery', null)->get();
        return response()->json($acom, 200);
    }
    public function filtrosAcoms($id)
    {
        if ($id == 0) {
            $response = AlumnoModelo::select('alumnos.no_de_control', 'alumnos.nombre', 'alumnos.apellidos', 'alumnos.carrera', 'alumnos.semestre', 'acoms.id', 'type_Acoms.type', 'acoms.dateDelivery', 'acoms.description', 'acoms.status')->join('acoms', 'alumnos.no_de_control', '=', 'acoms.no_de_control')->join('type_Acoms', 'acoms.typeAcom_id', '=', 'type_Acoms.id')->get();
            return response()->json($response, 200);
        }
        if ($id == 1) {
            $response = AlumnoModelo::select('alumnos.no_de_control', 'alumnos.nombre', 'alumnos.apellidos', 'alumnos.carrera', 'alumnos.semestre', 'acoms.id', 'type_Acoms.type', 'acoms.dateDelivery', 'acoms.description', 'acoms.status')->join('acoms', 'alumnos.no_de_control', '=', 'acoms.no_de_control')->join('type_Acoms', 'acoms.typeAcom_id', '=', 'type_Acoms.id')->where('acoms.dateDelivery', '!=', null)->get();
            return response()->json($response, 200);
        }
        if ($id == 2) {
            $response = AlumnoModelo::select('alumnos.no_de_control', 'alumnos.nombre', 'alumnos.apellidos', 'alumnos.carrera', 'alumnos.semestre', 'acoms.id', 'type_Acoms.type', 'acoms.dateDelivery', 'acoms.description', 'acoms.status')->join('acoms', 'alumnos.no_de_control', '=', 'acoms.no_de_control')->join('type_Acoms', 'acoms.typeAcom_id', '=', 'type_Acoms.id')->where('acoms.dateDelivery', '=', null)->get();
            return response()->json($response, 200);
        }
    }
    public function getdatosAcom()
    {
        $datosAcom = ConfigurationACOM::first();
        return response()->json($datosAcom, 200);
    }

    public function validarLiberacion($idAcom)
    {
        $response = Acom::find($idAcom);
        $status = $response->status;
        if($status == 0)
        {
            return response()->json(true, 200);
        }
        else{
            return response()->json(false, 200);
        }
    }

    public function destroy(Acom $acom, Request $request)
    {
        /*$res = Acom::find($idAcom)->delete();
        if($res == true)
        {
            return response()->json(True, 200);
        }
        else{
            return response()->json(false, 200);
        }*/
        $res = $acom::destroy($request->id);
        return response()->json($res, 200);
    }
}
