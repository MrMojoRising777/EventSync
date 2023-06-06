<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
    
    private function getFriendJson()
{
    $user = auth()->user();
    $friendsJson = $user->friends;
    $json = json_decode($friendsJson);
        
    return $json;
}

public function friends()
{
    $json = $this->getFriendJson();

    $usersArray = [];
    //dd($json);
    foreach ($json as $value) {
        $display = User::find($value);
        if ($display) {
            $usersArray[] = $display;
        }
    }
    
    // Rest of the logic using $usersArray
    
    return view('friends', compact('usersArray'));
}


    // public function friends(){
    //     $user = auth()->user();
        
    //     $friendsjson = $user->friends;
    //     $json = json_decode($friendsjson);
        
       
    //     $usersArray = [];

    //     foreach ($json as $value) {
    //         $display = \App\Models\User::find($value);
    //         if ($display) {
    //             $usersArray[] = $display;
    //         }
    //     }

    //     return view('friends', compact('usersArray'));
    // }

    public function findFriends(){
        $friends = \App\Models\User::all();

        return view('findFriends', compact('friends'));
    }

    public function searchFriends(request $request){
        $users = \App\Models\User::all();
        $search = $request->input('search');

        $friends = \App\Models\User::query();

        $friendsJson = $this->getFriendJson();

        $friends->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%');
        })
        ->whereNotIn('id', $friendsJson);

        $friends = $friends->get();

        return view('findFriends', compact('friends'));
    }

    public function AddFriends(request $request){
        $friendsAdded = $request->input('selectedCards');
        $json = $this->getFriendJson();

        $usersArray = [];
    

            foreach ($friendsAdded as $value) {
                $json[] += $value;
            }  
        dd($json);
    }
}
