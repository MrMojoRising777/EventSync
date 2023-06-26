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
                @if (isset($event->date))
                {{ "Event Date: " . $event->date }}
                @else
                {{ "Event Date: TBD" }}
                @endif
            </div>
        </div>

        <div class="container text-center">
            <div class="row justify-content-start">

                <!-- invited friends list -->
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

                <!-- Map Component -->
                <div class="col">
                    <div class="container text-center my-3">
                        <div class="row justify-content-start">
                            <div class="col">
                                <div class="card map-container">
                                    <div class="card-header">{{ __('Map') }}</div>
                                        <div class="card-body">
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

            <!-- get & set recommened_date -->
            <div class="container text-center">
                <div class="row justify-content-start">
                    <div class="col">
                        {{ "Current Recommended Date: " }}
                        @if ($recommended->isEmpty())
                            {{ "TBD" }}
                        @else
                            @foreach ($recommended as $date)
                                {{ $date->start_date }}
                            @endforeach
                        @endif
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
                        @if (!empty($recommended) && ($event->owner_id == $user->id))
                            @foreach ($recommended as $date)
                                <form method="POST" action="{{ route('SelectRecommended', ['id' => $event->id]) }}">
                                    @csrf
                                    @method('GET')
                                    <div class="form-group mt-3">
                                        <div class="col">
                                            <button type="submit" class="btn btn-success">Select recommended date as event date</button>
                                        </div>
                                    </div>
                                </form>
                            @endforeach 
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    // map initialization function
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