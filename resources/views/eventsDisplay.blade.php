@extends('layouts.app')

@section('content')

  <div class="container">
    @foreach ($events as $event)
      {{-- <div class="col-md-4"> --}}

        <div class="card">
            <div class="card-header">
              {{$event->name}}
            </div>
              <ul class="list-group list-group-flush">
              <li class="list-group-item"> {{$event->date}}</li>
              </ul>
            </div>
                          
        {{-- </div> --}}
    @endforeach 
    <div class="d-flex">
      {!! $events->links('pagination::bootstrap-5') !!}
    </div>
  </div>

@endsection