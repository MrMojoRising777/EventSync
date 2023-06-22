<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FriendController as  FriendController;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {   
        
        $user = auth()->user(); 
        // $events = $user->events()->orderBy('date', 'asc')->paginate(5);

        $currentDate = Carbon::today();

        $events = $user->events()
            ->whereDate('date', '>=', $currentDate)
            ->orderBy('date', 'asc')
            ->paginate(10);

        $ownedEvents = Event::where('owner_id', '=', $user->id)
            ->whereDate('date', '>=', $currentDate)
            ->orderBy('date', 'asc')
            ->paginate(10);
        //$events = $own->events()->orderBy('date', 'asc')->cursorPaginate(1);
        
        //dd($events);
        
        

        return view('events.eventsDisplay', compact('events', 'ownedEvents'));
    }

    public function show($id){
        $event = Event::find($id);

        if ($event) {
            $users = $event->users()->get();
            // Return the view with the event data
            return view('events.DisplayEvent', compact('event', 'users'));
        } else {
            // Event not found, handle the error or redirect
            return redirect()->back()->with('error', 'Event not found.');
        }

    }

    public function createEvent(Request $request)
    {
        
        $controller = new FriendController;
        $usersArray = $controller->getCurrentFriends();

        return view('events.createEvent', ['usersArray' => $usersArray]);
    }

    public function updatePivot(Request $request)
    {
        $eventId = $request->input('event_id');
        $selectedFriends = $request->input('selected_friends');

        // Find the event
        $event = Event::find($eventId);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Update the pivot table
        $event->users()->sync($selectedFriends);

        return response()->json(['message' => 'Pivot table updated']);
    }
}
