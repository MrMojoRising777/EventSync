@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="card mb-3">
      <div class="card-body">
        <h1 class="card-title">Maak een event aan</h1>

        <form method="POST" action="{{ route('calendar.events') }}">
          @csrf
          <div class="form-group mb-3">
            <div class="card mb-3">
              <div class="card-header">Geef het event een naam:</div>
                <div class="card-body">
                  <input type="text" name="event_name" id="event_name" class="form-control" required placeholder="Typ hier de naam van het event">
                </div>
            </div>
          </div>

          <!-- Calendar Component -->
          <div class="form-group">
            <div class="card mb-3">
              <div class="card-header">{{ __('Kies een datum:') }}</div>
              <div class="card-body">
                <div class="calendar-container">
                  @include('components.calendar')
                </div>
              </div>
            </div>
          </div>

          <!-- Map Component -->
          <div class="form-group">
            <div class="card mb-3">
              <div class="card-header">{{ __('Kies een locatie:') }}</div>
              <div class="card-body">
                <form>
                  <div class="row">
                    <div class="col-md-4 mb-3">
                      <label for="streetInput">Straat:</label>
                      <input id="streetInput" class="form-control" type="text" placeholder="Geef een straatnaam">
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="zipInput">Postcode:</label>
                      <input id="zipInput" class="form-control" type="text" placeholder="Geef een postcode">
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="cityInput">Stad:</label>
                      <input id="cityInput" class="form-control" type="text" placeholder="Geef een stad">
                    </div>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-primary" onclick="geocodeAddress()">Zoek</button>
                  </div>
                </form>
                @include('components.mapComp')
              </div>
            </div>
          </div>

          <div id="friends-container" class="friends-container">
            <div class="card mb-3">
              <div class="card-header">{{ __('Nodig vrienden uit:') }}</div>
              <div class="card-body">
                <ul>
                  <li>friend 1</li>
                  <li>friend 2</li>
                  <li>friend 3</li>
                </ul>
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Create Event</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    
  </script>

  <!-- Add ol.css manually -->
  <link rel="stylesheet" href="{{ asset('css/ol.css') }}">
@endsection