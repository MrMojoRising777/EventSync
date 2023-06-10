<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
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

    public function deleteAccount()
    {
        $user = Auth::user();
        $user->delete();

        return redirect()->route('home')->with('success', 'Account deleted successfully.');
    }
}