<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CrudEvents;
class CalendarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $events = CrudEvents::all(['id as id', 'event_name as title', 'event_start as start', 'event_end as end']);
            return response()->json($events);
        }

        return view('components.calendar');
    }
 
    public function calendarEvents(Request $request)
    {
 
        switch ($request->type) {
           case 'create':
              $event = CrudEvents::create([
                  'event_name' => $request->event_name,
                  'event_start' => $request->event_start,
                  'event_end' => $request->event_end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'edit':
              $event = CrudEvents::find($request->id)->update([
                  'event_name' => $request->event_name,
                  'event_start' => $request->event_start,
                  'event_end' => $request->event_end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'delete':
              $event = CrudEvents::find($request->id)->delete();
  
              return response()->json($event);
             break;
             
           default:
             # ...
             break;
        }
    }
    public function showCal(Request $request)
    {
        return view('createEvent');
    }
}