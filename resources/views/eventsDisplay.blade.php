@extends('layouts.app')

@section('content')
<div class="container">
  @if ($ownedEvents->isEmpty())
  <h2>Your Events</h2>
  <p><i><b>Currently you aren't part of any events. Don't wait on friends, create your own and invite them!</b></i></p>
  @else
  <h2>Your Events</h2>
  @foreach ($ownedEvents as $ownedevent)
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
          <a href="{{route('Event', ['id' => $ownedevent->id])}}">info</a>
        </div>
      </div>
    </div>
  </div>
  @endforeach
  @endif

  <div class="d-flex justify-content-center mt-4">
    {!! $ownedEvents->links('pagination::bootstrap-5') !!}
  </div>
</div>

<hr class="my-5">

<div class="container">
  <h2>Invited Events</h2>
  @foreach ($events as $event)
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
          <a href="{{route('Event', ['id' => $event->id])}}">info</a>
        </div>
      </div>
    </div>
  </div>
  @endforeach

  <div class="d-flex justify-content-center mt-4">
    {!! $events->links('pagination::bootstrap-5') !!}
  </div>
</div>
@endsection