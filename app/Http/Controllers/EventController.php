<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Acom;
use App\Models\Event;
use App\Models\Alumno;
use App\Enums\AcomEnums;
use App\Enums\EventEnums;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use App\Http\Requests\StoreAttendanceRequest;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class EventController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        Event::create($request->all());
        return response()->json('Guardado exitoso', 200);
    }

    public function validarEvent($id)
    {
        $verificar = Event::find($id);
        if($verificar->asistencias()->exists() == true)
            {
                return response()->json(true, 200);
            }
        else
        {
            return response()->json(false, 200);
        }
    }

    /**
     * Obtiene la lista de eventos
     * @return Illuminate\Http\Response
     */
    public function getEvents()
    {
        //$response = Event::all();
        $response = Event::select('events.id', 'events.type_event_id', 'events.nameEvent', 'type_events.type', 'events.organizer', 'events.date', 'events.place', 'events.description')->join('type_events', 'events.type_event_id', '=', 'type_events.id')->get();
        return response()->json($response, 200);
    }

    public function getEventsForStudents()
    {
        $date = Carbon::now();
        $date->format('Y-m-d H:i:s');
        $response = Event::select('events.id', 'events.type_event_id', 'events.nameEvent', 'type_events.type', 'events.organizer', 'events.date', 'events.place', 'events.description')->join('type_events', 'events.type_event_id', '=', 'type_events.id')->where('events.date', '>=', $date)->get();
        return response()->json($response, 200);
    }

    public function filtrosEventos($id)
    {
        if($id == 0)
        {
            $response = Event::select('events.id','events.type_event_id', 'events.nameEvent', 'type_events.type', 'events.organizer', 'events.date', 'events.place', 'events.description')->join('type_events', 'events.type_event_id','=','type_events.id')->get();
            return response()->json($response, 200);
        }
        if($id == 1)
        {
            $date = Carbon::now();
            $date->format('Y-m-d H:i:s');
            $response = Event::select('events.id','events.type_event_id', 'events.nameEvent', 'type_events.type', 'events.organizer', 'events.date', 'events.place', 'events.description')->join('type_events', 'events.type_event_id','=','type_events.id')->where('events.date','<', $date)->get();
            return response()->json($response, 200);
        }
        if($id == 2)
        {
            $date = Carbon::now();
            $date->format('Y-m-d H:i:s');
            $response = Event::select('events.id','events.type_event_id', 'events.nameEvent', 'type_events.type', 'events.organizer', 'events.date', 'events.place', 'events.description')->join('type_events', 'events.type_event_id','=','type_events.id')->where('events.date','>=', $date)->get();
            return response()->json($response, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        $event->nameEvent = $request->nameEvent;
        $event->type_event_id = $request->type_event_id;
        $event->organizer = $request->organizer;
        $event->date = $request->date;
        $event->place = $request->place;
        $event->description = $request->description;
        $event->save();

        return response()->json($event, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event, Request $request)
    {
        $res = $event::destroy($request->id);
        return response()->json($res, 200);
    }

    /**
     * Registrar la asistencia de un alumno al evento
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAttendance(Request $request)
    {
        $events = [
            (object)[
                'id' => EventEnums::EVENTO_DEPORTIVO,
                'numero_asistencias' => 3
            ],
            (object)[
                'id' => EventEnums::EVENTO_CULTURAL,
                'numero_asistencias' => 3
            ],
            (object)[
                'id' => EventEnums::EVENTO_CIVICO,
                'numero_asistencias' => 2
            ]
        ];
        foreach ($request->alumnos as $item)
        {
            $asistencia = new Asistencia;
            $asistencia->no_de_control = $item['no_de_control'];
            $asistencia->event_id = $request->event_id;
            $asistencia->save(); 

           $alumno = new Alumno ($item['no_de_control']);

           if($alumno->hasAllEventsCompleted($events)){
                $this->registrarAcom($item['no_de_control']);
           }
        }
        return response()->json(true,200);
    }

   /**
    * Desc-
    * @param
    * @return
    */
    public function getEventsforDate($date)
    {
        $horainicial = $date . ' 00:00:00';
        $horafinal = $date . ' 23:59:59';
        $events = Event::select('events.id', 'events.nameEvent', 'type_events.type', 'events.organizer', 'events.date', 'events.place', 'events.description')
            ->join('type_events', 'type_event_id', '=', 'type_events.id')
            ->whereBetween('date', [$horainicial, $horafinal])
            ->get();
        return response()->json($events, 200);
    }

    public function getEventsforPeriod($initialDate, $finalDate)
    {       
        $convert = Carbon::parse($finalDate);
        $finalDate = $convert->addDay(1);
        $events = Event::whereBetween('date', [$initialDate, $finalDate])
            ->get();
        return response()->json($events, 200);
    }

    public function registrarAcom($id)
    {
        $acom = new Acom;
        $acom->no_de_control = $id;
        $acom->description = "Liberación por evento extraescolar";
        $acom->typeAcom_id = AcomEnums::ACOM_POR_EVENTO_EXTRAESCOLAR;
        $acom->status = 0;
        $acom->save();
        return true;
    }

    public function validateAlumnoEvent($no_de_control, $event_id)
    {
        $validar = Asistencia::where('no_de_control',$no_de_control)->where('event_id', $event_id)->exists();
        if($validar == true)
        {
            return response()->json(true,200);
        }
        else
        {
            return response()->json(false,200);
        }
    }
}
