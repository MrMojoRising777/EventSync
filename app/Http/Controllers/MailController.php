<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class MailController extends Controller
{
    public function sendInvitations(Request $request)
    {
        $selectedFriendIds = $request->selected_friends;

        // Log the selected friend IDs
        \Log::info('Selected Friend IDs:', ['selectedFriendIds' => $selectedFriendIds]);

        if (!empty($selectedFriendIds)) {
            $selected_friends = User::whereIn('id', $selectedFriendIds)->get();

            // Log the selected friends
            \Log::info('Selected Friends Controller:', ['selectedFriends' => $selected_friends->toArray()]);

            $details = [
                'title' => 'Invitation',
                'body' => "You have been invited to an event created by {Name}. Please let {Name} know when you are available.",
            ];

            foreach ($selected_friends as $friend) {
                Mail::to($friend->email)->send(new TestEmail($details));
            }
        }

        return response()->json(['message' => 'Invitations sent successfully']);
    }
}