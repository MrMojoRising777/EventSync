<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class FriendController extends Controller
{
    
    
    
    private function getFriendJson() {

        // get the friends['id'] of the current user as an array
        $user = auth()->user();
        $friendsJson = $user->friends;
        $json = json_decode($friendsJson);
            
        return $json;
        }


    public function getCurrentFriends() {

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


    public function friends()
    {

        $usersArray = $this->getCurrentFriends();
        
        
        return view('friends.friends', compact('usersArray'));
    }

// Add friends functions
    public function searchFriends(request $request){
        $users = User::all();
        $search = $request->input('search');

        $own = auth()->user();

        $friends = User::where('id', '!=', $own->id);

        $friendsJson = $this->getFriendJson();

        $friends->where(function ($query) use ($search) {
            $own = auth()->user();
            $query->where('username', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->where('id', '!=', $own->id);
        })
        ->whereNotIn('id', $friendsJson);

        $friends = $friends->get();

        return view('friends.addFriends', compact('friends'));
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
            }
        

         
        // save selected friends to database
        $user = auth()->user();
        $user->friends = json_encode($json);
        $user->save();

        return redirect()->Route('friends');


    }


// Delete friends functions
    Public function FindFriends() {

        $usersArray = $this->getCurrentFriends();

        return view('friends.deleteFriends', compact('usersArray'));
    }

    public function DeleteFriends(request $request) {
        

        //get current friends array from the DB
        $json = $this->getFriendJson();
    
        //get friend users so it can check what friend needs to get deleted
        $items = $this->getCurrentFriends();
        
        
        $deleteFriends = [];

            // Check if any items are selected
            if (isset($_POST['selectedItems']) && is_array($_POST['selectedItems'])) {
                foreach ($_POST['selectedItems'] as $selectedItemId) {
                    // Find the selected item by id
                    $selectedItem = array_filter($items, function ($item) use ($selectedItemId) {
                        return $item['id'] == $selectedItemId;
                    });

                    if (!empty($selectedItem)) {
                        
                        $selectedItem = reset($selectedItem);
                        $deleteFriends[] += $selectedItem['id'];
                        
                    }
                }
                
                // delete the selected items from the json array
                $updatedFriendIds = array_diff($json, $deleteFriends);
                
            }
        
        // save updated friend information to database
        if (isset($updatedFriendIds)) {    
            $user = auth()->user();
            $updatedFriendIds = array_values($updatedFriendIds); // Convert to indexed array
            $user->friends = json_encode($updatedFriendIds);
            $user->save();
        }
        

        return redirect()->route('friends');
    }
}
