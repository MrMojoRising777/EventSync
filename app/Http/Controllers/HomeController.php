<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Http\Controllers\FriendController as  FriendController;

/**
 * Controller for handling home-related operations.
 */
class HomeController extends Controller
{
    /**
     * Create a new HomeController instance.
     * Require that user is authenticated for all methods.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard. Fetches the current user's friends, 
     * events and owned events and passes them to the 'home' view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usersArray = new FriendController();
        $friends = $usersArray->getCurrentFriends();

        $user = auth()->user();

        $events = $user->events()
            ->orderBy('date', 'asc')
            ->paginate(5);

        $ownedEvents = Event::where('owner_id', '=', $user->id)
            ->orderBy('date', 'asc')
            ->paginate(5);

        return view('home', compact('friends', 'events', 'ownedEvents'));
    }
}