<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for handling map-related operations.
 */
class MapController extends Controller
{
    /**
     * Display the map view and return events associated with the current user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
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