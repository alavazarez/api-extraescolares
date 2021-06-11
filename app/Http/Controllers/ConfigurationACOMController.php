<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfigurationAcom;

class ConfigurationAcomController extends Controller
{
    public function getAcomData()
    {
        $response = ConfigurationAcom::first();
        return response()->json($response, 200);
    }

    public function update(Request $request, $id)
    {
        $acom = ConfigurationAcom::find($id);
        
        $acom->nameBossDAE = $request->nameBossDAE;
        $acom->nameCoordinator = $request->nameCoordinator;
        $acom->nameBossDSE = $request->nameBossDSE;
        $acom->slogan = $request->slogan;
        $acom->save();

        return response()->json(true);   
    }
}
