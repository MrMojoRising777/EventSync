@extends('layouts.app')

@section('content')
<!-- Add ol.css manually -->
<link rel="stylesheet" href="{{ asset('css/ol.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ol/dist/ol.js"></script>

<div class="container">
    <div class="card mb-3">
        <div class="card-header">
            <div class="header-left">
                {{ "Event Name: " . $event->name }}
            </div>
            <div class="header-right">
                {{ "Event Date: " . $event->date }}
            </div>
        </div>

        <div class="container text-center">
            <div class="row justify-content-start">
                <div class="col">
                    <div class="card my-3">
                        <div class="card-header">
                            {{ "All Invited Friends: " }}
                        </div>
                        <div class="card-body">
                            @if (!empty($friends))
                                @foreach ($friends as $friend)
                                    {{ $friend->username }}
                                    <hr>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="container text-center my-3">
                        <div class="row justify-content-start">
                            <div class="col">
                            <div class="card map-container">
                                <div class="card-header">{{ __('Map') }}</div>
                                    <div class="card-body">
                                        <!-- Map Component -->
                                        <div id="map_{{ $event->id }}" class="map_events-display"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ "Event Location: " . $event->address . ', ' . $event->zipcode . ' ' . $event->city }}
                </div>
            </div>
        </div>

        <div class="container text-center">
            <div class="row justify-content-start">
                <div class="col">
                    {{ "Current Recommended Date: " }}
                    @foreach ($recommended as $date)
                        {{ $date->start_date }}
                    @endforeach
                    @if ($event->owner_id == $user->id)
                    <form method="POST" action="{{ route('Recommended', ['id' => $event->id]) }}">
                        @csrf
                        @method('GET')
                        <div class="form-group mt-3">
                            <div class="col">
                                <button type="submit" class="btn btn-success">Check recommended date</button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
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
</script>