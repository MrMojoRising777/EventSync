<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class MapController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $userId = Auth::user()->id;

            $events = Event::where('owner_id', $userId)
            ->select(['name', 'lat', 'long'])
            ->orWhereHas('users', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get();

            return response()->json($events);
        }

        return view('map');
    }
}