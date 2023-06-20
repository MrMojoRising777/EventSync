@extends('layouts.app')

@section('content')

<style>
    .checkbox-wrapper-16 *,
    .checkbox-wrapper-16 *:after,
    .checkbox-wrapper-16 *:before {
      box-sizing: border-box;
    }
  
    .checkbox-wrapper-16 .checkbox-input {
      clip: rect(0 0 0 0);
      -webkit-clip-path: inset(100%);
              clip-path: inset(100%);
      height: 1px;
      overflow: hidden;
      position: absolute;
      white-space: nowrap;
      width: 1px;
    }
    .checkbox-wrapper-16 .checkbox-input:checked + .checkbox-tile {
      border-color: #2260ff;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
      color: #2260ff;
    }
    .checkbox-wrapper-16 .checkbox-input:checked + .checkbox-tile:before {
      transform: scale(1);
      opacity: 1;
      background-color: #2260ff;
      border-color: #2260ff;
    }
    .checkbox-wrapper-16 .checkbox-input:checked + .checkbox-tile .checkbox-icon,
    .checkbox-wrapper-16 .checkbox-input:checked + .checkbox-tile .checkbox-label {
      color: #2260ff;
    }
    .checkbox-wrapper-16 .checkbox-input:focus + .checkbox-tile {
      border-color: #2260ff;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1), 0 0 0 4px #b5c9fc;
    }
    .checkbox-wrapper-16 .checkbox-input:focus + .checkbox-tile:before {
      transform: scale(1);
      opacity: 1;
    }
  
    .checkbox-wrapper-16 .checkbox-tile {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      width: 7rem;
      min-height: 7rem;
      border-radius: 0.5rem;
      border: 2px solid #b5bfd9;
      background-color: #fff;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
      transition: 0.15s ease;
      cursor: pointer;
      position: relative;
    }
    .checkbox-wrapper-16 .checkbox-tile:before {
      content: "";
      position: absolute;
      display: block;
      width: 1.25rem;
      height: 1.25rem;
      border: 2px solid #b5bfd9;
      background-color: #fff;
      border-radius: 50%;
      top: 0.25rem;
      left: 0.25rem;
      opacity: 0;
      transform: scale(0);
      transition: 0.25s ease;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='192' height='192' fill='%23FFFFFF' viewBox='0 0 256 256'%3E%3Crect width='256' height='256' fill='none'%3E%3C/rect%3E%3Cpolyline points='216 72.005 104 184 48 128.005' fill='none' stroke='%23FFFFFF' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'%3E%3C/polyline%3E%3C/svg%3E");
      background-size: 12px;
      background-repeat: no-repeat;
      background-position: 50% 50%;
    }
    .checkbox-wrapper-16 .checkbox-tile:hover {
      border-color: #2260ff;
    }
    .checkbox-wrapper-16 .checkbox-tile:hover:before {
      transform: scale(1);
      opacity: 1;
    }
  
    .checkbox-wrapper-16 .checkbox-icon {
      transition: 0.375s ease;
      color: #494949;
    }
    .checkbox-wrapper-16 .checkbox-icon svg {
      width: 3rem;
      height: 3rem;
    }
  
    .checkbox-wrapper-16 .checkbox-label {
      color: #707070;
      transition: 0.375s ease;
      text-align: center;
    }
  </style>


  <div class="container">
    <div class="card mb-3">
      <div class="card-body">
        <h1 class="card-title">Maak een event aan</h1>

        <form method="POST" action="{{ route('calendar.events') }}">
          @csrf
          <!-- get user_id for ownership -->
          <input type="hidden" name="owner_id" id="owner_id" value="{{ Auth::id() }}">
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
                <div class="calendar-container" id="calendarContainer">
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
                <div class="row">
                  @foreach ($usersArray as $friend)
                    <div class="col-md-4">
                      <div class="checkbox-wrapper-16">
                        <label class="checkbox-wrapper">
                          <input type="checkbox" class="checkbox-input" id="friend_{{$friend->id}}" name="selectedItems[]" value="{{$friend->id}}" />
                          <span class="checkbox-tile text-center align-middle">
                            {{$friend->username}}
                            <br>
                            {{$friend->id}}                           
                          </span>                                
                        </label>
                      </div>
                    </div>
                  @endforeach 
                </div>
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary" onclick="test()">Create Event</button>
        </form>
      </div>
    </div>
  </div>
  <!-- Add ol.css manually -->
  <link rel="stylesheet" href="{{ asset('css/ol.css') }}">

  <!-- toastr -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection

<script>
  var lat;
  var long;
  var event_date;
  var eventId;

  // Event listener: capture emitted MAP event
  window.addEventListener('coordinates-updated', function (event) {
    lat = event.detail.latitude;
    long = event.detail.longitude;
    // console.log(lat, long);
  });

  // Event listener: capture emitted CALENDAR event
  window.addEventListener('date-updated', function (event) {
    event_date = event.detail.date;
    // console.log(event_date);
  });

  function test() {
    console.log("Form input:");

    // Retrieve input values
    var eventName = document.getElementById('event_name').value;
    var street = document.getElementById('streetInput').value;
    var zipCode = document.getElementById('zipInput').value;
    var city = document.getElementById('cityInput').value;

    // Retrieve owner ID
    var ownerId = document.getElementById('owner_id').value;

    // Retrieve selected friends' IDs
    var selectedFriends = [];
    var checkboxes = document.querySelectorAll('input[name="selectedItems[]"]:checked');
    checkboxes.forEach(function (checkbox) {
      selectedFriends.push(checkbox.value);
    });

    // Log the input values
    console.log("event_name: " + eventName);
    console.log("owner_id: " + ownerId);
    console.log("--------------------------------");
    console.log("event_date:", event_date);
    console.log("event_lat + event_long:", lat, " + ", long);
    console.log("event address details:");
    console.log("street: " + street);
    console.log("zip code: " + zipCode);
    console.log("city: " + city);
    console.log("--------------------------------");
    console.log("invited friends:", selectedFriends);

    // Create new event object
    var newEvent = {
      event_name: eventName,
      event_date: event_date,
      lat: lat,
      long: long,
      owner_id: ownerId,
    };

    // Make AJAX request to save new event
    var SITEURL = "{{ url('/') }}";
    $.ajax({
      url: SITEURL + "/calendar-event",
      data: {
        event_name: eventName,
        event_date: event_date,
        lat: lat,
        long: long,
        owner_id: ownerId,
        type: 'create'
      },
      type: "POST",
      success: function (data) {
        // Handle success response
        console.log("New event created:", data);

        // Show toastr popup
        toastr.success('Event created successfully');

        // Get the event ID
        eventId = data.event.id;

        console.log("Event ID:", eventId);
        console.log("Selected Friends:", selectedFriends);

        // Make AJAX request to update pivot table
        $.ajax({
          url: "{{ route('event.updatePivot') }}",
          data: {
            event_id: eventId,
            selected_friends: selectedFriends,
            type: 'create'
          },
          type: "POST",
          success: function (data) {
            // Handle success response
            console.log("Pivot table updated:", data);

            // Redirect to home page after a delay
            setTimeout(function () {
              // window.location.href = "{{ route('home') }}";
            }, 2000); // Delay in milliseconds
          },
          error: function (xhr, status, error) {
            // Handle error response
            console.log("Error updating pivot table:", error);

            // Show toastr popup for error
            toastr.error('Error creating event');
          }
        });
      },
      error: function (xhr, status, error) {
        // Handle error response
        console.log("Error creating new event:", error);

        // Show toastr popup for error
        toastr.error('Error creating event');
      }
    });
  }
</script>