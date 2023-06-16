<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $userId = Auth::user()->id;
    
            $events = Events::where('owner_id', $userId)
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
                $event = Events::create([
                    'name' => $request->event_name,
                    'date' => $request->event_date,
                    'lat' => $request->lat,
                    'long' => $request->long,
                    'owner_id' => $request->owner_id,
                ]);
                return response()->json(['message' => 'Event created successfully', 'event' => $event]);
            
            case 'edit':
                $event = Events::findOrFail($request->id);
                $event->update([
                    'name' => $request->event_name,
                    'date' => $request->event_date,
                    'lat' => $request->lat,
                    'long' => $request->long,
                ]);
                return response()->json(['message' => 'Event updated successfully', 'event' => $event]);
            
            case 'delete':
                $event = Events::findOrFail($request->id);
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

    public function updatePivot(Request $request)
    {
        $eventId = $request->input('event_id');
        $selectedFriends = $request->input('selected_friends');

        // Find the event
        dd($eventID);
        $event = Events::find($eventId);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Update the pivot table
        $event->users()->sync($selectedFriends);

        return response()->json(['message' => 'Pivot table updated']);
    }
}