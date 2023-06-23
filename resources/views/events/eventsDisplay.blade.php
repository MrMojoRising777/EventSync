@extends('layouts.app')

@section('content')
<!-- Add ol.css manually -->
<link rel="stylesheet" href="{{ asset('css/ol.css') }}">

<div class="container">
  <h2 class="mb-4">Your Events</h2>
  @if ($ownedEvents->isEmpty())
    <p class="text-center"><i><b>Currently you don't have any organized events. Invite some friends, Sync up and create memories!</b></i></p>
  @else
    @foreach ($ownedEvents as $ownedevent)
    <div class="card mb-3">
  <div class="card-header">
    <strong>Event Name:</strong> {{ $ownedevent->name }}
  </div>
  <div class="container text-center">
    <div class="row align-items-center">
      <div class="col-4">
        <div class="container m-2">
          <div class="card map-container">
            <div class="card-header">{{ __('Map') }}</div>
            <div class="card-body">
              <!-- Map Component -->
              <div id="map_{{ $ownedevent->id }}" class="map_events-display"></div>
            </div>
          </div>
          <strong>Location:</strong> {{ $ownedevent->address }}, {{ $ownedevent->zipcode }} {{ $ownedevent->city }}
        </div>
      </div>
      <div class="col-4">
        <strong>Date:</strong> {{ $ownedevent->date }}
      </div>
      <div class="col-4">
        <form method="POST" action="{{ route('Event', ['id' => $ownedevent->id]) }}">
          @csrf
          @method('GET')
          <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
              <button type="submit" class="btn btn-success mt-2">info</button>
            </div>
          </div>
        </form>
        <form method="POST" action="{{ route('event.delete', ['id' => $ownedevent->id]) }}">
          @csrf
          @method('DELETE')
          <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
              <button type="submit" class="btn btn-danger" onclick="confirmDelete(event)">Verwijder event</button>
            </div>
          </div>
          <div class="col-4">

            <form method="POST" action="{{ route('Event', ['id' => $ownedevent->id]) }}">
              @csrf
              @method('GET')
              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-success" href="{{route('Event', ['id' => $ownedevent->id])}}">info</button>
                </div>
              </div>
            </form>
            
            <form method="POST" action="{{ route('send-cancellations', ['id' => $ownedevent->id]) }}">
              @csrf
              @method('DELETE')
              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your event?')">Verwijder event</button>
                </div>
              </div>
            </form>
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
  @if ($events->isEmpty())
  <h2>Invited Events</h2>
    <p><i><b>Currently you aren't part of any events. Don't wait on friends, create your own and invite them!</b></i></p>
  @else
    <h2>Invited Events</h2>
    @foreach ($events as $event)
    <div class="card mb-3">
      <div class="card-header">
        Event Name: {{ $event->name }}
      </div>
      <div class="container text-center">
        <div class="row align-items-center">
          <div class="col-4">
            <div class="container m-2">
              <div class="card map-container">
                <div class="card-header">{{ __('Map') }}</div>
                <div class="card-body">
                  <!-- Map Component -->
                  <div id="map_{{ $event->id }}" class="map_events-display"></div>
                </div>
              </div>
              <strong>Location:</strong> {{ $event->address }}, {{ $event->zipcode }} {{ $event->city }}
            </div>
          </div>
          <div class="col-4">
            Date: {{ $event->date }}
          </div>
          <div class="col-4">
            <form method="POST" action="{{ route('Event', ['id' => $event->id]) }}">
              @csrf
              @method('GET')
              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-success">info</button>
                </div>
              </div>
            </form>
            <form method="POST" action="{{ route('event.pivot.delete', ['id' => $event->id]) }}">
              @csrf
              @method('DELETE')
              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your event?')">Verwijder event</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  @endif

  <div class="d-flex justify-content-center mt-4">
    {!! $events->links('pagination::bootstrap-5') !!}
  </div>
</div>
@endsection

