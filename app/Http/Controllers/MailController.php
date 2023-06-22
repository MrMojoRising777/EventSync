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
        $ownerId = $request->owner_id;
        $eventDate = $request->event_date;
        $event_name = $request->event_name;
        $street = $request->address;
        $zipcode = $request->zipcode;
        $city = $request->city;

        // Fetch the owner from the users table
        $owner = User::find($ownerId);
        \Log::info('Owner:', ['owner' => $owner]);

        if ($owner) {
            // Log the selected friend IDs
            \Log::info('Selected Friend IDs:', ['selectedFriendIds' => $selectedFriendIds]);

            if (!empty($selectedFriendIds)) {
                $selected_friends = User::whereIn('id', $selectedFriendIds)->get();

                // Log the selected friends
                \Log::info('Selected Friends Controller:', ['selectedFriends' => $selected_friends->toArray()]);

                $details = [
                    'title' => "Invitation for $event_name",
                    'body' => "You have been invited to an event created by {$owner->username}.
                               Event details:
                               
                                   Place: $street, $zipcode, $city
                                   Date: $eventDate
                               
                               Please let {$owner->username} know when you are available.",
                ];
                

                foreach ($selected_friends as $friend) {
                    Mail::to($friend->email)->send(new TestEmail($details, function (Message $message) {
                        $message->setContentType('text/html');
                    }));
                }
            }

            return response()->json(['message' => 'Invitations sent successfully']);
        } else {
            return response()->json(['message' => 'Invalid owner ID'], 400);
        }
    }
}