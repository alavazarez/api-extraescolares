<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Repositories\Events\EventRepositoryInterface;
use Illuminate\Http\Request;

class EventController extends Controller
{
    private $event;

    public function __construct(EventRepositoryInterface $event)
    {
        $this->event = $event;
    }


    public function store(EventRequest $request)
    {
        return response()->json('Evento guardado con éxito',201);
    }

    public function show()
    {
        return $this->event->all();
    }

    public function update(Request $request, Event $event)
    {
        //
    }

    public function destroy(Event $event)
    {
        //
    }
}
