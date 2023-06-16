<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    public function index()
    {
        $availabilities = Availability::with(['user', 'event'])->get();
        return view('availabilities.index', compact('availabilities'));
    }

    public function create()
    {
        $users = User::all();
        $events = Event::all();
        return view('availabilities.create', compact('users', 'events'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'event_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $validatedData['user_id'] = Auth::id();

        $existingAvailability = Availability::where('user_id', $validatedData['user_id'])
            ->where('event_id', $validatedData['event_id'])
            ->first();

        if ($existingAvailability) {
            return redirect()->route('availabilities.index')
                ->with('error', 'You have already created an availability for this event.');
        }

        Availability::create($validatedData);

        return redirect()->route('availabilities.index')
            ->with('success', 'Availability created successfully.');
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

        return redirect()->route('availabilities.index')
            ->with('success', 'Availability updated successfully.');
    }



    public function destroy(Availability $availability)
    {
        $availability->delete();
        return redirect()->route('availabilities.index');
    }
}