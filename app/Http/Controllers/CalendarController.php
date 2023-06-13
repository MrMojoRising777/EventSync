<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CrudEvents;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $events = CrudEvents::all(['id as id', 'event_name as title', 'event_date as start', 'event_date as end']);
            return response()->json($events);
        }

        return view('components.calendar');
    }

    public function calendarEvents(Request $request)
    {
        $event = null;

        switch ($request->type) {
            case 'create':
                $event = CrudEvents::create([
                    'event_name' => $request->event_name,
                    'event_date' => $request->event_date,
                    'lat' => $request->lat,
                    'long' => $request->long,
                ]);
                return response()->json(['message' => 'Event created successfully', 'event' => $event]);
            
            case 'edit':
                $event = CrudEvents::findOrFail($request->id);
                $event->update([
                    'event_name' => $request->event_name,
                    'event_date' => $request->event_date,
                    'lat' => $request->lat,
                    'long' => $request->long,
                ]);
                return response()->json(['message' => 'Event updated successfully', 'event' => $event]);
            
            case 'delete':
                $event = CrudEvents::findOrFail($request->id);
                $event->delete();
                return response()->json(['message' => 'Event deleted successfully']);
            
            default:
                return response()->json(['message' => 'Invalid request']);
        }
    }

    public function showCal(Request $request)
    {
        return view('createEvent');
    }
}