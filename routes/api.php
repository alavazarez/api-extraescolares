<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Repository\EstudianteRepository;
use App\Http\Resources\AlumnoAsistenciaDeEventos;

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


Route::get('/alumno/avance/{no_de_control}', 'AlumnoController@obtenerAvanceDeEventos');
Route::get('/formacion-integral/{no_de_control}', 'FormacionIntegralController@find');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')
    ->get('/evento', 'EventController@getEvents');

Route::middleware('auth:sanctum')
    ->post('/evento/store', 'EventController@store');

Route::middleware('auth:sanctum')
    ->get('/evento/validarEvent/{id}', 'EventController@validarEvent');

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

Route::get('/alumno/{matricula}', 'AlumnoController@find');

Route::middleware('auth:sanctum')
    ->get('/alumnos/event/', 'AlumnoController@getAlumnos');

Route::get('/alumno/asisteencias/{id}', 'AlumnoController@asistencias');

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

Route::get('/eventoForStudents', 'EventController@getEventsForStudents');

Route::middleware('auth:sanctum')
    ->get('/eventForDate/{date}', 'EventController@getEventsforDate');

Route::middleware('auth:sanctum')
    ->get('/alumnoEvent/{no_de_control}/{event_id}', 'EventController@validateAlumnoEvent');

Route::middleware('auth:sanctum')
    ->get('/event/filtrosEventos/{idFiltro}', 'EventController@filtrosEventos');

Route::middleware('auth:sanctum')
    ->get('/acom/filtrosAcoms/{idFiltro}', 'AcomController@filtrosAcoms');

Route::get('/acom/findAcomAlumno/{id}', 'AcomController@findAcomAlumno');

Route::middleware('auth:sanctum')
    ->post('/user/registerUser', 'UserController@register');

Route::middleware('auth:sanctum')
    ->post('/user/verifiPassOld/{id}', 'UserController@update');

Route::post('/user/sendEmailReset', 'UserController@resetPasswordRequest');

Route::post('/user/passwordReset', 'UserController@resetPassword');

Route::middleware('auth:sanctum')
    ->post('/logout', 'UserController@logout');

Route::get('/acom/datosAcom', 'AcomController@getdatosAcom');

Route::middleware('auth:sanctum')
    ->get('/event/getEventsAlumno/{no_de_control}', 'EventController@getEventsAlumno');

Route::middleware('auth:sanctum')
    ->get('/alumno/StatusExtraescolar/{no_de_control}', 'AlumnoController@getStatusExtraescolar');

Route::middleware('auth:sanctum')
    ->get('/event/getAlumnosEvent/{idEvent}', 'EventController@getAlumnosEvent');

Route::middleware('auth:sanctum')
    ->post('/event/removeAsistenciaAlumno/{no_de_control}/{idEvento}', 'EventController@removeAsistenciaAlumno');

Route::middleware('auth:sanctum')
    ->get('/acom/validarLiberacion/{idAcom}', 'AcomController@validarLiberacion');

Route::middleware('auth:sanctum')
    ->post('/acom/destroy', 'AcomController@destroy');
