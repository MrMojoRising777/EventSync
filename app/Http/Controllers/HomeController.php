<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;

use App\Http\Controllers\FriendController as  FriendController;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $usersArray = new FriendController();
        $friends = $usersArray->getCurrentFriends();

        $user = auth()->user(); 

        $events = $user->events()
            // ->whereDate('date', '>=', $currentDate)
            ->orderBy('date', 'asc')
            ->paginate(5);

        $ownedEvents = Event::where('owner_id', '=', $user->id)
            // ->whereDate('date', '>=', $currentDate)
            ->orderBy('date', 'asc')
            ->paginate(5);

        return view('home', compact('friends', 'events', 'ownedEvents'));
    }
    


}