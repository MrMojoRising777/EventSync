@extends('layouts.app')

@section('content')

<!-- Add ol.css manually -->
<link rel="stylesheet" href="{{ asset('css/ol.css') }}">
  <style>
    
  </style>

  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card dashboard-container">
          <div class="card-header">
            <h2>{{ __('Dashboard') }}</h2>
          </div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            <h4>{{ __('Welkom, :name', ['name' => Auth::user()->username]) }}!</h4>

              <div class="row">
                <div class="col-lg-2">

                  <div class="card friends-container">
                    <div class="card-header">{{ __('Vrienden') }}</div>
                    <div class="card-body">
                      <ul>
                        @foreach ($usersArray as $friend)
                          <li>
                            <a href="/friends">{{ $friend->username }}</a>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>

              <div class="col-lg-10">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="card calendar-container">
                      <div class="card-header">{{ __('Geplande activiteiten') }}</div>
                      <div class="card-body">
                        <!-- Calendar Component -->
                        @include('components.calendar')
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="card map-container">
                      <div class="card-header">{{ __('Map') }}</div>
                        <div class="card-body">
                          <!-- Map Component -->
                          <div id="map"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

<!-- JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ol/dist/ol.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

<script>
  var map;
  var marker;
  var vectorSource;

  function initMap(response) {
    console.log(response);
    // Map initialization code
    map = new ol.Map({
      target: 'map',
      layers: [
        new ol.layer.Tile({
          source: new ol.source.OSM()
        })
      ],
      view: new ol.View({
        center: ol.proj.fromLonLat([5.5368901, 50.995]), // Center on Belgium coordinates: [longitude, latitude]
        minZoom: 7 // Minimum zoom
      })
    });

    vectorSource = new ol.source.Vector();

    var vectorLayer = new ol.layer.Vector({
      source: vectorSource
    });

    map.addLayer(vectorLayer);

    if (response && response.length > 0) {
      // Iterate over the response array and create markers
      response.forEach(function(event) {
        console.log('Latitude:', event.lat, 'Longitude:', event.long);
        var lat = event.lat;
        var long = event.long;

        var marker = new ol.Feature({
          geometry: new ol.geom.Point(ol.proj.fromLonLat([lat, long])) // Marker coordinates: [latitude, longitude]
        });

        var markerStyle = new ol.style.Style({
          image: new ol.style.Icon({
            anchor: [0.5, 1], // Set the anchor point of the marker icon
            src: 'https://openlayers.org/en/latest/examples/data/icon.png' // URL to the marker icon image
          })
        });

        marker.setStyle(markerStyle);
        vectorSource.addFeature(marker);
      });

      // Calculate the extent of the vector source
      var extent = vectorSource.getExtent();

      // Check the number of features in the vector source
      var featureCount = vectorSource.getFeatures().length;

      // Fit the view to the extent or set zoom level manually
      if (featureCount > 1) {
        map.getView().fit(extent, { padding: [50, 50, 50, 50] });
      } else if (featureCount === 1) {
        var markerCoordinates = vectorSource.getFeatures()[0].getGeometry().getCoordinates();
        map.getView().setCenter(markerCoordinates);
        map.getView().setZoom(12); // Adjust the zoom level as desired
      }
    } else {
      // Set a default extent and zoom level for the view
      var defaultCenter = ol.proj.fromLonLat([5.5368901, 50.995]);
      var defaultZoom = 7;
      map.getView().setCenter(defaultCenter);
      map.getView().setZoom(defaultZoom);
    }
  }

  $(document).ready(function() {
    // Set moment.js locale to Dutch
    moment.locale('nl');

    // fetch header information
    var SITEURL = "{{ url('/') }}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: SITEURL + "/map",
      type: "GET",
      success: function(response) {
        console.log('Response:', response);
        initMap(response); // Pass the events directly to the initMap function
      },
      error: function() {
        // Handle error if the AJAX request fails
        console.log('Failed to fetch map events');
      }
    });
  });
</script>