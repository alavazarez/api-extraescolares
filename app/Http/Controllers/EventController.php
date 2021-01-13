<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Acom;
use App\Models\Event;
use App\Models\Alumno;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use App\Http\Requests\StoreAttendanceRequest;
use App\Enums\EventEnums;
use App\Enums\AcomEnums;
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
        /**
         * Cofiguracion de acom
         */
        $events = [
            [
                'id' => EventEnums::EVENTO_DEPORTIVO,
                'numero_asistencias' => 3
            ],
            [
                'id' => EventEnums::EVENTO_CULTURAL,
                'numero_asistencias' => 3
            ],
            [
                'id' => EventEnums::EVENTO_CIVICO,
                'numero_asistencias' => 2
            ]
        ];
        foreach ($request->alumnos as $item) {
            $alumno = Alumno::findOrFail($item['id']);
            //Se registra el id del alumno en la tabla pivot, con el evento del id
            $alumno->events()->attach($request->event_id);

            if ($alumno->events()->asistenciaCompletada($events))
                $this->registrarAcom($alumno->id);
        }

        return response()->json(true,200);
    }

    public function getEventsforDate($date)
    {
        $horainicial = $date . ' 00:00:00';
        $horafinal = $date . ' 23:59:59';
        $events = Event::select('events.id', 'events.nameEvent', 'type_events.type', 'events.organizer', 'events.date', 'events.place', 'events.description')->join('type_events', 'type_event_id', '=', 'type_events.id')->whereBetween('date', [$horainicial, $horafinal])->get();
        return response()->json($events, 200);
    }

    public function getEventsforPeriod($initialDate, $finalDate)
    {
        $events = Event::whereBetween('date', [$initialDate, $finalDate])->get();
        return response()->json($events, 200);
    }

    public function registrarAcom($id)
    {
        $acom = new Acom;
        $acom->alumno_id = $id;
        $acom->description = "Liberación por evento extraescolar";
        $acom->typeAcom_id = AcomEnums::ACOM_POR_EVENTO_EXTRAESCOLAR;
        $acom->status = 0;
        $acom->save();
    }
}
