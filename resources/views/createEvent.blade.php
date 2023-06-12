@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Create Event</h1>

    <form method="POST" action="{{ route('calendar.events') }}">
      @csrf
      <div class="form-group">
        <label for="event_name">Event Name</label>
        <input type="text" name="event_name" id="event_name" class="form-control" required>
      </div>

      <!-- Calendar Component -->
      <div class="form-group">
        <div class="card">
          <div class="card-header">{{ __('Date') }}</div>
          <div class="card-body">
            <label for="event_date">Event Date</label>
            <div class="calendar-container">
              @include('components.calendar')
            </div>
          </div>
        </div>
      </div>

      <!-- Map Component -->
      <div class="form-group">
        <div class="card">
          <div class="card-header">{{ __('Map') }}</div>
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
        <div class="card friends-container">
          <div class="card-header">{{ __('Friends') }}</div>
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

  <script>
    // Initialize the map and add a marker
    var map = L.map('map').setView([51.505, -0.09], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
    }).addTo(map);
    var marker = L.marker([51.505, -0.09]).addTo(map);

    // Add your JavaScript code to handle the map interaction, friend container, and other functionalities

    // Example code for using FullCalendar
    $(document).ready(function () {
      $('#event_date').datepicker();

      $('#calendar').fullCalendar({
        events: "{{ route('calendar.index') }}",
        editable: true,
        eventDrop: function (event, delta) {
          // Handle event drop
        },
        eventResize: function (event, delta) {
          // Handle event resize
        },
        eventClick: function (event) {
          // Handle event click
        }
      });
    });
  </script>

  <!-- Add ol.css manually -->
  <link rel="stylesheet" href="{{ asset('css/ol.css') }}">
@endsection