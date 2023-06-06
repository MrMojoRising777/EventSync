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

    public function findFriends(){
        $friends = \App\Models\User::all();

        return view('findFriends', compact('friends'));
    }

    public function searchFriends(request $request){
        $users = \App\Models\User::all();
        $search = $request->input('search');

        $friends = \App\Models\User::query();


        $friends->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
                //->orWhere('id', 'like', '%' . $search . '%');
        });

        $friends = $friends->get();

        return view('findFriends', compact('friends'));
    }

    public function AddFriends(request $request){
        $friendsAdded = $request->input('selectedCards');
        
        dd($friendsAdded);
    }
}
