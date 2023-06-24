<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Availability;
use App\Models\RecommendedDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

        $availabilities = Availability::with(['user', 'event'])->get();

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

        for ($i = 0; $i < count($start_dates); $i++) {
            // Check if a valid end_date for a given start_date exists
            if (isset($end_dates[$i]) && $end_dates[$i] >= $start_dates[$i]) {
                $existingAvailability = Availability::where('user_id', $user_id)
                    ->Where('event_id', $event_id)
                    ->whereBetween('start_date', [$start_dates[$i], $end_dates[$i]])
                    ->orWhereBetween('end_date', [$start_dates[$i], $end_dates[$i]])
                    ->first();

                if ($existingAvailability) {
                    return redirect()->route('availabilities.index')
                        ->with('error', 'You have already created an availability for this event in the specified time range.');
                }

                $availability = new Availability;
                $availability->user_id = $user_id;
                $availability->event_id = $event_id;
                $availability->start_date = $start_dates[$i];
                $availability->end_date = $end_dates[$i];
                $availability->save();
            }
        }

        // $this->calculateOverlappingDates($event_id);

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

    private function calculateOverlappingDates($event_id)
    {
        // Fetch all the availabilities for the event.
        $availabilities = Availability::where('event_id', $event_id)
            ->orderBy('start_date', 'asc')
            ->get();

        // Clear previous recommended dates for the event.
        RecommendedDate::where('event_id', $event_id)->delete();

        for ($i = 0; $i < count($availabilities); $i++) {
            for ($j = $i + 1; $j < count($availabilities); $j++) {
                if ($availabilities[$i]->end_date >= $availabilities[$j]->start_date) {
                    RecommendedDate::create([
                        'event_id' => $event_id,
                        'start_date' => max($availabilities[$i]->start_date, $availabilities[$j]->start_date),
                        'end_date' => min($availabilities[$i]->end_date, $availabilities[$j]->end_date),
                    ]);
                }
            }
        }
    }
}
