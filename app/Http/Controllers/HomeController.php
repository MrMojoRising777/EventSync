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



//private functions
    private function getFriendJson() {

        // get the friends['id'] of the current user as an array
        $user = auth()->user();
        $friendsJson = $user->friends;
        $json = json_decode($friendsJson);
            
        return $json;
    }


    private function getCurrentFriends() {

        // get the current users friends info as an array
        $json = $this->getFriendJson();

        $usersArray = [];
        foreach ($json as $value) {
            $display = User::find($value);
            if ($display) {
                $usersArray[] = $display;
            }
        }

        return $usersArray;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        
        $usersArray = $this->getCurrentFriends();

        return view('home', compact('usersArray'));
    }
    


    public function friends()
    {

        $usersArray = $this->getCurrentFriends();
        
        
        return view('friends', compact('usersArray'));
    }

// Add friends functions
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
        // array_filter doesnt work with eloquent, so chagne it to an array instead
        $items = $itemsEloquent->toArray();

        //get current friends from the DB
        $json = $this->getFriendJson();

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
        

         
        // save selected friends to database
        $user = auth()->user();
        $user->friends = json_encode($json);
        $user->save();

        return redirect()->route('friends');


    }


// Delete friends functions
    Public function FindFriends() {

        $usersArray = $this->getCurrentFriends();

        return view('deleteFriends', compact('usersArray'));
    }

    public function DeleteFriends(request $request) {
        

        //get current friends array from the DB
        $json = $this->getFriendJson();
    
        //get friend users so it can check what friend needs to get deleted
        $items = $this->getCurrentFriends();
        
        
        $deleteFriends = [];

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
                
                // delete the selected items from the json array
                $updatedFriendIds = array_diff($json, $deleteFriends);
                
                echo "</ul>";
            }
        
        // save updated friend information to database
        if (isset($updatedFriendIds)) {    
            $user = auth()->user();
            $user->friends = json_encode($updatedFriendIds);
            $user->save();
        }
        

        return redirect()->route('friends');
    }
}
