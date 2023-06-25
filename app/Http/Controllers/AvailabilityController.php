<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Availability;
use App\Models\RecommendedDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class AvailabilityController
 * Handles the CRUD operations for User Availability.
 */
class AvailabilityController extends Controller
{
    /**
     * Display a listing of the availabilities.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch current authenticated user and today's date
        $user = auth()->user();
        $currentDate = Carbon::today();

        // Fetch the user's events and owned events (both upcoming and past)
        $events = $user->events()
            ->orderBy('date', 'asc')
            ->paginate(5);

        $ownedEvents = Event::where('owner_id', '=', $user->id)
            ->orderBy('date', 'asc')
            ->paginate(5);

        // Fetch the user's availabilities
        $availabilities = Availability::where('user_id', '=', $user->id)->get();

        // Return the view with the fetched data
        return view('availabilities.index', compact('events', 'ownedEvents', 'availabilities'));
    }

    /**
     * Show the form for creating a new availability.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Fetch all users and events
        $users = User::all();
        $events = Event::all();

        // Return the view with the fetched data
        return view('availabilities.create', compact('users', 'events'));
    }

    /**
     * Store a newly created availability in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'event_id' => 'required',
            'start_date' => 'required|array',
            'end_date' => 'required|array',
        ]);

        // Extract data from request
        $event_id = $request->event_id;
        $start_dates = $request->start_date;
        $end_dates = $request->end_date;
        $user_id = Auth::id();

        // Create new availabilities
        foreach ($start_dates as $start_date) {
            $existingAvailability = Availability::where('user_id', $user_id)
                ->where('event_id', $event_id)
                ->where('start_date', $start_date)
                ->first();

            // Only create a new availability if one does not already exist
            if (empty($existingAvailability)) {
                $availability = new Availability;
                $availability->user_id = $user_id;
                $availability->event_id = $event_id;
                $availability->start_date = $start_date;
                $availability->end_date = $start_date;
                $availability->save();
            }
        }

        // Redirect back to the availabilities index page
        return redirect()->route('availabilities.index')
            ->with('success', 'Availabilities created successfully.');
    }

    /**
     * Display the specified availability.
     *
     * @param  \App\Models\Availability  $availability
     * @return \Illuminate\Http\Response
     */
    public function show(Availability $availability)
    {
        return view('availabilities.show', compact('availability'));
    }

    /**
     * Show the form for editing the specified availability.
     *
     * @param  \App\Models\Availability  $availability
     * @return \Illuminate\Http\Response
     */
    public function edit(Availability $availability)
    {
        // Fetch all users and events
        $users = User::all();
        $events = Event::all();

        // Return the view with the fetched data
        return view('availabilities.edit', compact('availability', 'users', 'events'));
    }

    /**
     * Update the specified availability in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Availability  $availability
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Availability $availability)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'event_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Add user id to the validated data
        $validatedData['user_id'] = Auth::id();

        // Check for existing availability excluding the current one
        $existingAvailability = Availability::where('user_id', $validatedData['user_id'])
            ->where('event_id', $validatedData['event_id'])
            ->where('id', '!=', $availability->id)
            ->first();

        // Redirect back with error message if existing availability found
        if ($existingAvailability) {
            return redirect()->route('availabilities.index')
                ->with('error', 'You have already created an availability for this event.');
        }

        // Update the availability
        $availability->update($validatedData);

        // Calculate overlapping dates
        $this->calculateOverlappingDates($validatedData['event_id']);

        // Redirect back to the availabilities index page
        return redirect()->route('availabilities.index')
            ->with('success', 'Availability updated successfully.');
    }

    /**
     * Remove the specified availability from storage.
     *
     * @param  \App\Models\Availability  $availability
     * @return \Illuminate\Http\Response
     */
    public function destroy(Availability $availability)
    {
        // Delete the availability
        $availability->delete();

        // Redirect back to the availabilities index page
        return redirect()->route('availabilities.index');
    }

    /**
     * Calculate overlapping dates for the given event id.
     *
     * @param  int $event_id
     * @return \Illuminate\Http\Response
     */
    public function calculateOverlappingDates($event_id)
    {
        // Fetch the availability with the maximum overlapping dates
        $availability = Availability::select('start_date', DB::raw('COUNT(start_date) as count'))
            ->where('event_id', '=', $event_id)
            ->groupBy('start_date')
            ->orderBy('count', 'desc')
            ->orderBy('start_date', 'asc')
            ->first();

        // Clear previous recommended dates for the event
        RecommendedDate::where('event_id', $event_id)->delete();

        // Create a new recommended date if a valid availability was found
        if (!empty($availability)) {
            $recommended = new RecommendedDate;
            $recommended->start_date = $availability->start_date;
            $recommended->event_id = $event_id;
            $recommended->end_date = $availability->start_date;
            $recommended->save();
        }

        // Redirect back to the previous page
        return redirect()->back();
    }

    /**
     * Select a recommended date for the given event id.
     *
     * @param  int $event_id
     * @return \Illuminate\Http\Response
     */
    public function SelectRecommendedDate($event_id)
    {
        // Fetch the recommended date for the given event id
        $recommended = RecommendedDate::where('event_id', $event_id)->first();

        // Update the event date if a recommended date was found
        if (!empty($recommended)) {
            $date = Event::where('id', $event_id)->first();
            $date->date = $recommended->start_date;
            $date->save();
        }

        // Redirect back to the previous page
        return redirect()->back();
    }
}
