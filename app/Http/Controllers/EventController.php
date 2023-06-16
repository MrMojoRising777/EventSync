<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\HomeController as  HomeController;
use App\Models\CrudEvents;
use App\Models\User;

class EventController extends Controller
{
    public function index()
    {   
        
        $own = auth()->user();

        $events = $own->crud_events()->get();
        
        //dd($events);
        
        

        return view('eventsDisplay', compact('events'));
    }
}
