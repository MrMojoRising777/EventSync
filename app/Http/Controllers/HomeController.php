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
        $json = $this->getFriendJson();

        $usersArray = [];
        //dd($json);
        foreach ($json as $value) {
            $display = User::find($value);
            if ($display) {
                $usersArray[] = $display;
            }
        }
        return view('home', compact('usersArray'));
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
    
    
    return view('friends', compact('usersArray'));
}


    public function searchFriends(request $request){
        $users = \App\Models\User::all();
        $search = $request->input('search');

        $own = auth()->user();

        $friends = \App\Models\User::where('id', '!=', $own->id);

        $friendsJson = $this->getFriendJson();

        $friends->where(function ($query) use ($search) {
            $own = auth()->user();
            $query->where('username', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->where('id', '!=', $own->id);
        })
        ->whereNotIn('id', $friendsJson);

        $friends = $friends->get();

        return view('addFriends', compact('friends'));
    }

    

    public function AddFriends(request $request){

        //get all users so it can check what friend needs to get added
        $itemsEloquent = User::all();
        $items = $itemsEloquent->toArray();

        //get current friends from the DB
        $json = $this->getFriendJson();

            // Execute when form is submitted otherwise ignore this snippet...
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if any items are selected
            if (isset($_POST['selectedItems']) && is_array($_POST['selectedItems'])) {
                echo "<h2>Selected Items:</h2>";
                echo "<ul>";
                foreach ($_POST['selectedItems'] as $selectedItemId) {
                    // Find the selected item by id
                    $selectedItem = array_filter($items, function ($item) use ($selectedItemId) {
                        return $item['id'] == $selectedItemId;
                    });

                    if (!empty($selectedItem)) {
                        
                        $selectedItem = reset($selectedItem);
                        $json[] += $selectedItem['id'];
                        echo "<li>{$selectedItem['username']} (ID: {$selectedItem['id']})</li>";
                    }
                }
                echo "</ul>";
            }
        }

         

        $user = auth()->user();
        $user->friends = json_encode($json);
        $user->save();

        return redirect()->route('friends');


    }

    Public function FindFriends() {
        $json = $this->getFriendJson();

        $usersArray = [];
        //dd($json);
        foreach ($json as $value) {
            $display = User::find($value);
            if ($display) {
                $usersArray[] = $display;
            }
        }

        return view('deleteFriends', compact('usersArray'));
    }

    public function DeleteFriends(request $request) {
        

        //get current friends from the DB
        $json = $this->getFriendJson();

        //get friend users so it can check what friend needs to get deleted
         $items = [];
        //dd($json);
        foreach ($json as $value) {
            $display = User::find($value);
            if ($display) {
                $items[] = $display;
            }
        }
        
        $deleteFriends = [];

            // Execute when form is submitted otherwise ignore this snippet...
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if any items are selected
            if (isset($_POST['selectedItems']) && is_array($_POST['selectedItems'])) {
                echo "<h2>Selected Items:</h2>";
                echo "<ul>";
                foreach ($_POST['selectedItems'] as $selectedItemId) {
                    // Find the selected item by id
                    $selectedItem = array_filter($items, function ($item) use ($selectedItemId) {
                        return $item['id'] == $selectedItemId;
                    });

                    if (!empty($selectedItem)) {
                        
                        $selectedItem = reset($selectedItem);
                        $deleteFriends[] += $selectedItem['id'];
                        
                        echo "<li>{$selectedItem['username']} (ID: {$selectedItem['id']})</li>";
                    }
                }
                //dd($json, $updatedFriendIds);
                $updatedFriendIds = array_diff($json, $deleteFriends);
                echo "</ul>";
            }
        }

        $user = auth()->user();
        if (!empty($updatedFriendIds)) {
            $user->friends = json_encode($updatedFriendIds);
        }
        $user->save();

        return redirect()->route('friends');
    }
}
