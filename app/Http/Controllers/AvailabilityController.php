<?php
namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CrudEvents;

class AvailabilityController extends Controller
{
    public function index()
    {
        $availabilities = Availability::all();

        return view('availabilities.index', compact('availabilities'));
    }

    public function create()
    {
        $event = Event::findOrFail($eventId);
        $users = User::all(); // Retrieve all users from the database

        return view('availabilities.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        Availability::create($request->all());

        return redirect()->route('availabilities.index')
            ->with('success', 'Availability created successfully.');
    }

    public function edit(Availability $availability)
    {
        return view('availabilities.edit', compact('availability'));
    }

    public function update(Request $request, Availability $availability)
    {
        $request->validate([
            'user_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $availability->update($request->all());

        return redirect()->route('availabilities.index')
            ->with('success', 'Availability updated successfully.');
    }

    public function destroy(Availability $availability)
    {
        $availability->delete();

        return redirect()->route('availabilities.index')
            ->with('success', 'Availability deleted successfully.');
    }
}
