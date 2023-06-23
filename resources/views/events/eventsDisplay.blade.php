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
              <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your event')">Cancel event</button>
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
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your event')">Decline event</button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ol/dist/ol.js"></script>
<script>
  // Map initialization $OwnedEvents
  @foreach ($ownedEvents as $ownedevent)
    function initMap_{{ $ownedevent->id }}() {
      const eventLatLng = ol.proj.fromLonLat([{{ $ownedevent->lat }}, {{ $ownedevent->long }}]);
      const map = new ol.Map({
        target: 'map_{{ $ownedevent->id }}',
        layers: [
          new ol.layer.Tile({
            source: new ol.source.OSM()
          })
        ],
        view: new ol.View({
          center: eventLatLng,
          zoom: 12
        })
      });
      const marker = new ol.Feature({
        geometry: new ol.geom.Point(eventLatLng)
      });
      const markerLayer = new ol.layer.Vector({
        source: new ol.source.Vector({
          features: [marker]
        }),
        style: new ol.style.Style({
          image: new ol.style.Icon({
            src: 'https://openlayers.org/en/latest/examples/data/icon.png'
          })
        })
      });
      map.addLayer(markerLayer);
    }
    window.addEventListener('load', initMap_{{ $ownedevent->id }});
  @endforeach

  // Map initialization $InvitedEvents
  @foreach ($events as $event)
  function initMap_{{ $event->id }}() {
    const eventLatLng = ol.proj.fromLonLat([{{ $event->lat }}, {{ $event->long }}]);
    const map = new ol.Map({
      target: 'map_{{ $event->id }}',
      layers: [
        new ol.layer.Tile({
          source: new ol.source.OSM()
        })
      ],
      view: new ol.View({
        center: eventLatLng,
        zoom: 12
      })
    });
    const marker = new ol.Feature({
      geometry: new ol.geom.Point(eventLatLng)
    });
    const markerLayer = new ol.layer.Vector({
      source: new ol.source.Vector({
        features: [marker]
      }),
      style: new ol.style.Style({
        image: new ol.style.Icon({
          src: 'https://openlayers.org/en/latest/examples/data/icon.png'
        })
      })
    });
    map.addLayer(markerLayer);
  }
  window.addEventListener('load', initMap_{{ $event->id }});
@endforeach

  
</script>