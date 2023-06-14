<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CrudEvents;
use Illuminate\Support\Facades\Auth;

class MapController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $userId = Auth::user()->id;

            $events = CrudEvents::where('owner_id', $userId)
                ->select(['event_name', 'lat', 'long'])
                ->get();

            return response()->json($events);
        }

        return view('map');
    }
}