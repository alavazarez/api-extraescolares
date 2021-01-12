<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Requests\StoreAttendanceRequest;
use App\Models\Event;
use App\Models\Alumno;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        return response()->json('Guardado exitoso',200);
    }

    /**
     * Obtiene la lista de eventos
     * @return Illuminate\Http\Response
     */
    public function getEvents(){
        //$response = Event::all();
        $response = Event::select('events.id','events.type_event_id', 'events.nameEvent', 'type_events.type', 'events.organizer', 'events.date', 'events.place', 'events.description')->join('type_events', 'events.type_event_id','=','type_events.id')->get();
        return response()->json($response, 200);
    }

    public function getEventsForStudents(){
        $date = Carbon::now();
        $date->format('Y-m-d H:i:s');
        $response = Event::select('events.id','events.type_event_id', 'events.nameEvent', 'type_events.type', 'events.organizer', 'events.date', 'events.place', 'events.description')->join('type_events', 'events.type_event_id','=','type_events.id')->where('events.date','>=', $date)->get();
        return response()->json($response, 200);
    }
    public function filtrosEventos($id){
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
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
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

        return response()->json($event,200);
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
        return response()->json($res,200);
    }

    /**
     * Registrar la asistencia de un alumno al evento
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAttendance (Request $request)
    {
        foreach ($request->alumnos as $item) {
            $alumno = Alumno::findOrFail($item['id']);
            $alumno->events()->attach($request->event_id);
        }
        return response()->json(true); 
    }
    public function getEventsforDate($date)
    {
        $horainicial = $date.' 00:00:00';
        $horafinal = $date.' 23:59:59';
        $events = Event::select('events.id', 'events.nameEvent', 'type_events.type', 'events.organizer', 'events.date', 'events.place', 'events.description')->join('type_events', 'type_event_id', '=', 'type_events.id')->whereBetween('date', [$horainicial, $horafinal])->get();
        return response()->json($events,200);
    }

    public function getEventsforPeriod($initialDate, $finalDate)
    {
        $events = Event::whereBetween('date', [$initialDate, $finalDate])->get();
        return response()->json($events,200);
    }

    public function validateAlumnoEvent($alumnoId, $eventId)
    {
        $validar = Event::select('alumno_event.alumno_id','alumno_event.event_id')
                    ->join('alumno_event','events.id','=','alumno_event.event_id')
                    ->where('alumno_event.event_id',$eventId)
                    ->where('alumno_event.alumno_id',$alumnoId)
                    ->count();
        if($validar == 1)
        {
            return response()->json(true,200);
        }
        else
        {
            return response()->json(false,200);
        }
    }
}
