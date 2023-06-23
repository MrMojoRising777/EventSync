<?php

namespace App\Http\Controllers;

use App\Mail\InviteEmail;
use App\Mail\CancelEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Event;

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
                    Mail::to($friend->email)->send(new InviteEmail($details, function (Message $message) {
                        $message->setContentType('text/html');
                    }));
                }
            }

            return response()->json(['message' => 'Invitations sent successfully']);
        } else {
            return response()->json(['message' => 'Invalid owner ID'], 400);
        }
    }

    public function sendCancelations($id)
    {        
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $users = $event->users()->get();

        $details = [
            'title' => 'Cancellation Test Email',
            'body' => 'This is a test cancellation email.',
        ];

        if (!empty($users)) {

            foreach ($users as $user) {
                $email = $user->email;
                Mail::to($email)->send(new CancelEmail($details));
            }
        }

        $event->delete();

        return redirect()->back()->with('success', 'Event deleted and cancellation emails sent successfully.');

    }
}