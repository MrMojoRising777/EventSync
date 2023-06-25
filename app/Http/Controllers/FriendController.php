<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

/**
 * Controller for handling friend-related operations.
 */
class FriendController extends Controller
{
    /**
     * Get friend IDs of the authenticated user as a JSON array.
     *
     * @return array
     */
    private function getFriendJson()
    {
        $user = auth()->user();
        $friendsJson = $user->friends;
        $json = json_decode($friendsJson);

        return $json;
    }

    /**
     * Get current user's friends info as an array.
     *
     * @return array
     */
    public function getCurrentFriends()
    {
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
     * Display friends of the current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function friends()
    {
        $usersArray = $this->getCurrentFriends();

        return view('friends.friends', compact('usersArray'));
    }

    /**
     * Search for users that can be added as friends.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function searchFriends(Request $request)
    {
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

    /**
     * Add selected users as friends.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function AddFriends(Request $request)
    {
        $itemsEloquent = User::all();
        $items = $itemsEloquent->toArray();
        $json = $this->getFriendJson();

        if ($request->has('selectedItems') && is_array($request->input('selectedItems'))) {
            foreach ($request->input('selectedItems') as $selectedItemId) {
                $selectedItem = array_filter($items, function ($item) use ($selectedItemId) {
                    return $item['id'] == $selectedItemId;
                });

                if (!empty($selectedItem)) {
                    $selectedItem = reset($selectedItem);
                    $json[] += $selectedItem['id'];
                }
            }
        }

        $user = auth()->user();
        $user->friends = json_encode($json);
        $user->save();

        return redirect()->Route('friends');
    }

    /**
     * Display a list of current friends to delete.
     *
     * @return \Illuminate\Http\Response
     */
    public function FindFriends()
    {
        $usersArray = $this->getCurrentFriends();

        return view('friends.deleteFriends', compact('usersArray'));
    }

    /**
     * Delete selected friends.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function DeleteFriends(Request $request)
    {
        $json = $this->getFriendJson();
        $items = $this->getCurrentFriends();
        $deleteFriends = [];

        if ($request->has('selectedItems') && is_array($request->input('selectedItems'))) {
            foreach ($request->input('selectedItems') as $selectedItemId) {
                $selectedItem = array_filter($items, function ($item) use ($selectedItemId) {
                    return $item['id'] == $selectedItemId;
                });

                if (!empty($selectedItem)) {
                    $selectedItem = reset($selectedItem);
                    $deleteFriends[] += $selectedItem['id'];
                }
            }

            $updatedFriendIds = array_diff($json, $deleteFriends);
        }

        if (isset($updatedFriendIds)) {
            $user = auth()->user();
            $updatedFriendIds = array_values($updatedFriendIds);
            $user->friends = json_encode($updatedFriendIds);
            $user->save();
        }

        return redirect()->route('friends');
    }
}
