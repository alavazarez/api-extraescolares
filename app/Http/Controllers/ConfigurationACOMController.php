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
}
