<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $profilePicture = $user->profile_picture ? Storage::url('profile-pictures/' . $user->profile_picture) : null;
        return view('profile.show', compact('user', 'profilePicture'));
    }

    public function updateUsername(Request $request)
    {
        $user = Auth::user();
        $user->username = $request->input('username');
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Username updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Password updated successfully.');
    }

    public function updatePicture(Request $request)
    {
        $user = Auth::user();

        // Validate the uploaded file
        $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Get the uploaded file
        $picture = $request->file('picture');

        // Generate a unique name for the file
        $fileName = uniqid() . '.' . $picture->getClientOriginalExtension();

        // Store the file in the storage/app/public/profile-pictures directory
        $picture->move('public/profile-pictures', $fileName);

        // Update the user's profile picture
        $user->profile_picture = $fileName;
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile picture updated successfully.');
    }

    public function deleteAccount()
    {
        $user = Auth::user();
        $user->delete();

        return redirect()->route('home')->with('success', 'Account deleted successfully.');
    }
}