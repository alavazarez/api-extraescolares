<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')
    ->get('/evento', 'EventController@getEvents');

Route::middleware('auth:sanctum')
    ->post('/evento/store', 'EventController@store');

Route::middleware('auth:sanctum')
    ->post('/evento/edit/{id}', 'EventController@update');

Route::middleware('auth:sanctum')
    ->post('/evento/destroy', 'EventController@destroy');

Route::middleware('auth:sanctum')
    ->post('/evento/asistencia', 'EventController@storeAttendance');

Route::middleware('auth:sanctum')
    ->get('/acom/configuration', 'ConfigurationAcomController@getAcomData');

Route::middleware('auth:sanctum')
    ->post('/acom/configuration/{id}', 'ConfigurationAcomController@update');

Route::middleware('auth:sanctum')
    ->get('/alumnos', 'AlumnoController@getAlumnos');

Route::middleware('auth:sanctum')
    ->get('/alumno/{matricula}', 'AlumnoController@find');

Route::middleware('auth:sanctum')
    ->get('/alumno/count/{matricula}', 'AlumnoController@getEventsDeportivos');

Route::middleware('auth:sanctum')
    ->get('/acom/index', 'AcomController@getAcoms');

Route::middleware('auth:sanctum')
    ->post('/acom/store/{id}', 'AcomController@store');

Route::middleware('auth:sanctum')
    ->get('/acom/index', 'AcomController@getAcoms');

Route::middleware('auth:sanctum')
    ->get('/event/reports/exportExcel/{id}', 'AlumnoController@exportExcel');

Route::middleware('auth:sanctum')
    ->get('/event/reports/exportExcelEvents/{date}', 'EventController@getEventsforDate');

Route::middleware('auth:sanctum')
    ->get('/event/reports/exportExcelPeriodEvents/{initialDate}/{finalDate}', 'EventController@getEventsforPeriod');

Route::middleware('auth:sanctum')
    ->post('/acom/deliver/{id}', 'AcomController@deliverAcom');

Route::middleware('auth:sanctum')
    ->get('/acom/reports/exportarAcomLiberados/{initialDate}/{finalDate}', 'AcomController@exportarAcomLiberados');

Route::middleware('auth:sanctum')
    ->get('/acom/reports/exportarAcomsPendientes', 'AcomController@exportarAcomsPendientes');

Route::middleware('auth:sanctum')
    ->get('/eventoForStudents', 'EventController@getEventsForStudents');

Route::middleware('auth:sanctum')
    ->get('/eventForDate/{date}', 'EventController@getEventsforDate');
