<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $userId = Auth::user()->id;
    
            $events = Event::where('owner_id', $userId)
                ->orWhereHas('users', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->select(['id as id', 'name as title', 'date as start', 'date as end'])
                ->get();
    
                $formattedEvents = [];
                foreach ($events as $event) {
                    $formattedEvents[] = [
                        'id' => $event->id,
                        'title' => $event->title,
                        'start' => date('Y-m-d', strtotime($event->start)),
                        'end' => date('Y-m-d', strtotime($event->end)),
                    ];
                }                
    
                return response()->json($formattedEvents);
        }
    
        return view('components.calendar');
    }

    public function calendarEvents(Request $request)
    {
        $event = null;
        //dd($request->event_name);
        switch ($request->type) {
            case 'create':
                $event = Event::create([
                    'name' => $request->event_name,
                    'date' => $request->event_date,
                    'lat' => $request->lat,
                    'long' => $request->long,
                    'owner_id' => $request->owner_id,
                    'address' => $request->address,
                    'zipcode' => $request->zipcode,
                    'city' => $request->city,
                ]);
                return response()->json(['message' => 'Event created successfully', 'event' => $event]);
            
            case 'edit':
                $event = Event::findOrFail($request->id);
                $event->update([
                    'name' => $request->event_name,
                    'date' => $request->event_date,
                    'lat' => $request->lat,
                    'long' => $request->long,
                ]);
                return response()->json(['message' => 'Event updated successfully', 'event' => $event]);
            
            case 'delete':
                $event = Event::findOrFail($request->id);
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