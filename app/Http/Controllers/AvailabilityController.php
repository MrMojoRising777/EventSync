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

class AvailabilityController extends Controller
{
    public function index()
    {
        $user = auth()->user(); 
        $currentDate = Carbon::today();

        $events = $user->events()
            ->whereDate('date', '>=', $currentDate)
            ->orderBy('date', 'asc')
            ->paginate(5);

        $ownedEvents = Event::where('owner_id', '=', $user->id)
            ->whereDate('date', '>=', $currentDate)
            ->orderBy('date', 'asc')
            ->paginate(5);

        $availabilities = Availability::where('user_id', '=', $user->id)->get();

        return view('availabilities.index', compact('events', 'ownedEvents', 'availabilities'));
    }

    public function create()
    {
        $users = User::all();
        $events = Event::all();
        return view('availabilities.create', compact('users', 'events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required',
            'start_date' => 'required|array',
            'end_date' => 'required|array',
        ]);

        $event_id = $request->event_id;
        $start_dates = $request->start_date;
        $end_dates = $request->end_date;
        $user_id = Auth::id();

        foreach ($start_dates as $start_date) {
            $existingAvailability = Availability::where('user_id', $user_id)
                ->where('event_id', $event_id)
                ->where('start_date', $start_date)
                ->first();
            
            if (empty($existingAvailability)) {
                $availability = new Availability;
                $availability->user_id = $user_id;
                $availability->event_id = $event_id;
                $availability->start_date = $start_date;
                $availability->end_date = $start_date;
                $availability->save();
            }
        }

        return redirect()->route('availabilities.index')
            ->with('success', 'Availabilities created successfully.');
    }

    public function show(Availability $availability)
    {
        return view('availabilities.show', compact('availability'));
    }

    public function edit(Availability $availability)
    {
        $users = User::all();
        $events = Event::all();
        return view('availabilities.edit', compact('availability', 'users', 'events'));
    }

    public function update(Request $request, Availability $availability)
    {
        $validatedData = $request->validate([
            'event_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $validatedData['user_id'] = Auth::id();

        $existingAvailability = Availability::where('user_id', $validatedData['user_id'])
            ->where('event_id', $validatedData['event_id'])
            ->where('id', '!=', $availability->id)
            ->first();

        if ($existingAvailability) {
            return redirect()->route('availabilities.index')
                ->with('error', 'You have already created an availability for this event.');
        }

        $availability->update($validatedData);
        
        $this->calculateOverlappingDates($validatedData['event_id']);

        return redirect()->route('availabilities.index')
            ->with('success', 'Availability updated successfully.');
    }

    public function destroy(Availability $availability)
    {
        $availability->delete();
        return redirect()->route('availabilities.index');
    }

    public function calculateOverlappingDates($event_id)
    {


       

        $availability = Availability::select('start_date', DB::raw('COUNT(start_date) as count'))
            ->where('event_id', '=', $event_id)
            ->groupBy('start_date')
            ->orderBy('count', 'desc')
            ->orderBy('start_date', 'asc')
            ->first();


        // Clear previous recommended dates for the event.
        RecommendedDate::where('event_id', $event_id)->delete();

        $reccomended = new RecommendedDate;
        $reccomended->start_date = $availability->start_date;
        $reccomended->event_id = $event_id;
        $reccomended->end_date = $availability->start_date;
        $reccomended->save();

        return redirect()->back();

    }
}
