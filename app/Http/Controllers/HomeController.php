<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('home');
    }

    public function friends(){
        $user = auth()->user();
        
        $friendsjson = $user->friends;
        $json = json_decode($friendsjson);
        
       
        $usersArray = [];

        foreach ($json as $value) {
            $display = \App\Models\User::find($value);
            if ($display) {
                $usersArray[] = $display;
            }
        }

        return view('friends', compact('usersArray'));
    }
}
