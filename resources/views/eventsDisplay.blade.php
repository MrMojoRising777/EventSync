@extends('layouts.app')

@section('content')

<div class="container">
  {{"Your Events"}}
  @foreach ($ownedEvents as $ownedevent)
    {{-- <div class="col-md-4"> --}}

      <div class="card">
          <div class="card-header">
            {{$ownedevent->name}}
          </div>
            
            
          <div class="container text-center">
            <div class="row justify-content-start">
              <div class="col-4">
                {{-- {{$ownedevent->location}} --}}
              </div>
              
              <div class="col-4">
                {{$ownedevent->date}}
              </div>

              <div class="col-4">
                <a href="{{route('Event', ['id' => $ownedevent->id])}}">{{"info"}}</a>
              </div>
              
            </div>
          </div>
      </div>   
                       
      {{-- </div> --}}
  @endforeach 
  <div class="d-flex">
    {!! $events->links('pagination::bootstrap-5') !!}
  </div>
</div>
<div class="container">
  <hr>
</div>
  <div class="container">
    {{"Invited Events"}}
    @foreach ($events as $event)
      {{-- <div class="col-md-4"> --}}

        <div class="card">
          <div class="card-header">
            {{$event->name}}
          </div>
            
            
          <div class="container text-center">
            <div class="row justify-content-start">
              <div class="col-4">
                {{-- {{$event->location}} --}}
              </div>
              
              <div class="col-4">
                {{$event->date}}
              </div>

              <div class="col-4">
                <a href="{{route('Event', ['id' => $event->id])}}">{{"info"}}</a>
              </div>
              
            </div>
          </div>
        </div>                  
        {{-- </div> --}}
    @endforeach 
    <div class="d-flex">
      {!! $events->links('pagination::bootstrap-5') !!}
    </div>
  </div>

@endsection