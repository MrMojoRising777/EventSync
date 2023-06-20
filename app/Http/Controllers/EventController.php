<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\HomeController as  HomeController;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    public function index()
    {   
        
        $user = auth()->user(); 
        $events = $user->events()->orderBy('date', 'asc')->paginate(5);


        //$events = $own->events()->orderBy('date', 'asc')->cursorPaginate(1);
        
        //dd($events);
        
        

        return view('eventsDisplay', compact('events'));
    }
}
