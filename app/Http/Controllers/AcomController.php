<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acom;

class AcomController extends Controller
{
    public function store(Request $request)
    {
        Acom::create($request->all());
        return response()->json('Guardado exitoso',200);
    }

    public function getAcoms()
    {
        $response = Acom::with('alumnos')->orderBy('id')->get();
        return response()->json($response, 200);
    }
}
