public function create()
{
    $users = User::all();
    $events = Event::all();
    return view('availabilities.create', compact('users', 'events'));
}

public function edit(Availability $availability)
{
    $users = User::all();
    $events = Event::all();
    return view('availabilities.edit', compact('availability', 'users', 'events'));
}
