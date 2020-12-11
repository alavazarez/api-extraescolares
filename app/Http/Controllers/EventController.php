<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
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
        $response = Event::all();
        return response()->json($response, 200);
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

        $event->name = $request->name;
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
}
