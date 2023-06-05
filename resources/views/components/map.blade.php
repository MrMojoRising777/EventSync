<!DOCTYPE html>
<html>
  <head>
    <title>Map Example</title>
    <link rel="stylesheet" href="https://openlayers.org/en/v6.6.1/css/ol.css" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
      #map {
        width: 100%;
        height: 400px;
      }
      .input-container {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
      }
      .input-container label {
        margin-right: 10px;
        font-weight: bold;
      }
      .input-container input {
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
      }
      .input-container button {
        padding: 5px 10px;
        background-color: #4caf50;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }
    </style>
  </head>
  <body>
  <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">
        {{ config('app.name', 'Laravel') }}
      </a>
                <a class="navbar-brand" href="{{ url('/map') }}">
                    {{ config('Map', 'Map') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    <div class="input-container">
      <label for="streetInput">Street:</label>
      <input id="streetInput" type="text" placeholder="Enter a street name" />
    </div>
    <div class="input-container">
      <label for="zipInput">Zip Code:</label>
      <input id="zipInput" type="text" placeholder="Enter a zip code" />
    </div>
    <div class="input-container">
      <label for="cityInput">City:</label>
      <input id="cityInput" type="text" placeholder="Enter a city" />
    </div>
    <div class="input-container">
      <button onclick="geocodeAddress()">Search</button>
    </div>
    <div id="map"></div>
    <script src="https://cdn.jsdelivr.net/npm/ol/dist/ol.js"></script>
    <script>
      var map;
      var marker;
      var vectorSource;

      function initMap() {
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
          zoom: 10 // Adjust the zoom level as needed
        })
      });

      // Create a marker overlay
      marker = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat([5.5368901, 50.995])) // Marker coordinates: [longitude, latitude]
      });

      var markerStyle = new ol.style.Style({
        image: new ol.style.Icon({
          anchor: [0.5, 1], // Set the anchor point of the marker icon
          src: 'https://openlayers.org/en/latest/examples/data/icon.png' // URL to the marker icon image
        })
      });

      marker.setStyle(markerStyle);

      vectorSource = new ol.source.Vector({
        features: [marker]
      });

      var vectorLayer = new ol.layer.Vector({
        source: vectorSource
      });

      // Make the marker draggable
      var dragInteraction = new ol.interaction.Translate({
        features: new ol.Collection([marker])
      });

      map.addInteraction(dragInteraction);

      // Display the latitude and longitude when the marker is dragged
      marker.on('change', function () {
        var coordinates = marker.getGeometry().getCoordinates();
        var lonLat = ol.proj.toLonLat(coordinates);
        console.log('Latitude: ' + lonLat[0] + ', Longitude: ' + lonLat[1]);
      });

      map.addLayer(vectorLayer);
    }

    function geocodeAddress() {
      var street = document.getElementById('streetInput').value;
      var zip = document.getElementById('zipInput').value;
      var city = document.getElementById('cityInput').value;
      var address = street + ', ' + zip + ' ' + city + ', Belgium';

      var url =
        'https://nominatim.openstreetmap.org/search?format=json&q=' +
        encodeURIComponent(address) +
        '&countrycodes=be&limit=1';

      fetch(url)
        .then(function(response) {
          return response.json();
        })
        .then(function(data) {
          if (data.length > 0) {
            var lat = parseFloat(data[0].lat);
            var lon = parseFloat(data[0].lon);
            var coordinate = ol.proj.fromLonLat([lon, lat]);

            marker.setGeometry(new ol.geom.Point(coordinate));

            map.getView().setCenter(coordinate);
            map.getView().setZoom(15);
          } else {
            alert('Address not found');
          }
        })
        .catch(function(error) {
          console.log('Error:', error);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
      initMap();
    });
    </script>
  </body>
</html>