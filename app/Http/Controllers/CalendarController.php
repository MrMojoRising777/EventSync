<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for handling calendar-related operations.
 */
class CalendarController extends Controller
{
    /**
     * Display the calendar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Fetch the user's ID
            $userId = Auth::user()->id;

            // Retrieve the events owned by the user or where the user is a participant
            $events = Event::where('owner_id', $userId)
                ->orWhereHas('users', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->select(['id as id', 'name as title', 'date as start', 'date as end'])
                ->get();

            // Format the events for the calendar
            $formattedEvents = [];
            foreach ($events as $event) {
                $formattedEvents[] = [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => date('Y-m-d', strtotime($event->start)),
                    'end' => date('Y-m-d', strtotime($event->end)),
                ];
            }

            // Return the formatted events as a JSON response
            return response()->json($formattedEvents);
        }

        // Return the calendar view
        return view('components.calendar');
    }

    /**
     * Handle events on the calendar (create, edit, delete).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function calendarEvents(Request $request)
    {
        $event = null;
        switch ($request->type) {
            case 'create':
                // Create a new event
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
                // Update an existing event
                $event = Event::findOrFail($request->id);
                $event->update([
                    'name' => $request->event_name,
                    'date' => $request->event_date,
                    'lat' => $request->lat,
                    'long' => $request->long,
                ]);
                return response()->json(['message' => 'Event updated successfully', 'event' => $event]);

            case 'delete':
                // Delete an event
                $event = Event::findOrFail($request->id);
                $event->delete();
                return response()->json(['message' => 'Event deleted successfully']);

            default:
                // Handle an invalid request
                return response()->json(['message' => 'Invalid request']);
        }
    }

    /**
     * Show the event creation page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showCal(Request $request)
    {
        return view('createEvent');
    }
}
