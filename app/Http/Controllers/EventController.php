<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FriendController as  FriendController;
use App\Models\Event;
use App\Models\User;
use App\Models\RecommendedDate;
use Carbon\Carbon;

/**
 * Controller for handling event-related operations.
 */
class EventController extends Controller
{
    /**
     * Display the events for the logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve the logged in user
        $user = auth()->user();

        // Get the current date
        $currentDate = Carbon::today();

        // Retrieve events related to the user and order them by date
        $events = $user->events()->orderBy('date', 'asc')->paginate(5);

        // Retrieve events owned by the user and order them by date
        $ownedEvents = Event::where('owner_id', '=', $user->id)->orderBy('date', 'asc')->paginate(5);

        return view('events.eventsDisplay', compact('events', 'ownedEvents'));
    }

    /**
     * Display the specified event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);
        $user = auth()->user();

        if ($event) {
            $friends = $event->users()->get();
            $recommended = $event->recommendedDates()->get();

            return view('events.DisplayEvent', compact('event', 'friends', 'recommended', 'user'));
        } else {
            return redirect()->back()->with('error', 'Event not found.');
        }
    }

    /**
     * Show the form to create a new event.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createEvent(Request $request)
    {
        $controller = new FriendController;
        $usersArray = $controller->getCurrentFriends();

        return view('events.createEvent', ['usersArray' => $usersArray]);
    }

    /**
     * Update the pivot table for an event.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePivot(Request $request)
    {
        $eventId = $request->input('event_id');
        $selectedFriends = $request->input('selected_friends');

        $event = Event::find($eventId);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $event->users()->sync($selectedFriends);

        return response()->json(['message' => 'Pivot table updated']);
    }

    /**
     * Remove the specified event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteEvent($id)
    {
        $event = Event::find($id);
        $event->delete();

        return redirect()->back()->with('success', 'Event deleted successfully.');
    }

    /**
     * Remove the specified event from the authenticated user's events.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletePivot($id)
    {
        $user = auth()->user();
        $event = Event::find($id);

        $user->events()->detach($event);

        return redirect()->back()->with('success', 'You no longer go to this event.');
    }
}