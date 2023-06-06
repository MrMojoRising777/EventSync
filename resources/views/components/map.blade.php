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

      /* map */
      #map {
        width: 100%;
        height: 400px;
      }

      /* user input form/card */
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

      /* user input auto complete */
      .ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
      }

      .ui-autocomplete .ui-menu-item {
        padding: 8px 12px;
        cursor: pointer;
      }

      .ui-autocomplete .ui-menu-item:hover {
        background-color: #f5f5f5;
      }
    </style>
  </head>
  <body>
    <!-- header -->
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

        <div class="card">
          <div class="card-body">
            <form>
              <div class="form-row">
                <div class="col-md-4 mb-3">
                  <label for="streetInput">Straat:</label>
                  <input id="streetInput" class="form-control" type="text" placeholder="Enter a street name" />
                </div>
                <div class="col-md-4 mb-3">
                  <label for="zipInput">Postcode:</label>
                  <input id="zipInput" class="form-control" type="text" placeholder="Enter a zip code" />
                </div>
                <div class="col-md-4 mb-3">
                  <label for="cityInput">Stad:</label>
                  <input id="cityInput" class="form-control" type="text" placeholder="Enter a city" />
                </div>
              </div>
              <div class="form-group">
                <button class="btn btn-primary" onclick="geocodeAddress()">Search</button>
              </div>
            </form>
          </div>
        </div>

        <div id="map" style="height: 400px;"></div>

        <script src="https://cdn.jsdelivr.net/npm/ol/dist/ol.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

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

      // Enable predictive street and city suggestions
      $(document).ready(function() {
        $('#streetInput').autocomplete({
          source: function(request, response) {
            $.ajax({
              url: 'https://nominatim.openstreetmap.org/search',
              method: 'GET',
              headers: {
                'Accept-Language': 'nl' // Specify the language as Dutch
              },
              dataType: 'json',
              data: {
                q: request.term + ', België', // Search for addresses in Belgium
                format: 'json',
                addressdetails: 1,
                limit: 5
              },
              success: function(data) {
                var uniqueCities = getUniqueCities(data);
                response($.map(uniqueCities, function(item) {
                  var address = item.address;
                  var city = address.city || address.town || address.village || address.hamlet;
                  var zip = address.postcode || '';
                  return {
                    label: city,
                    value: city,
                    zip: zip
                  };
                }));
              }
            });
          },
          minLength: 2,
          select: function(event, ui) {
            updateZipCode(ui.item.zip);
          }
        });

        $('#cityInput').autocomplete({
          source: function(request, response) {
            $.ajax({
              url: 'https://nominatim.openstreetmap.org/search',
              method: 'GET',
              headers: {
                'Accept-Language': 'nl' // Specify the language as Dutch
              },
              dataType: 'json',
              data: {
                q: request.term + ', België', // Search for addresses in Belgium
                format: 'json',
                addressdetails: 1,
                limit: 5
              },
              success: function(data) {
                var uniqueCities = getUniqueCities(data);
                response($.map(uniqueCities, function(item) {
                  var address = item.address;
                  var city = address.city || address.town || address.village || address.hamlet;
                  var zip = address.postcode || '';
                  return {
                    label: city,
                    value: city,
                    zip: zip
                  };
                }));
              }
            });
          },
          minLength: 2,
          select: function(event, ui) {
            updateZipCode(ui.item.zip);
          }
        });

        // Function to get unique cities from the Nominatim API response
        function getUniqueCities(data) {
          var uniqueCities = [];
          var citiesMap = new Map();

          data.forEach(function(item) {
            var address = item.address;
            var city = address.city || address.town || address.village || address.hamlet;
            if (city && !citiesMap.has(city)) {
              citiesMap.set(city, true);
              uniqueCities.push(item);
            }
          });

          return uniqueCities;
        }

        // Function to update the zip code based on the selected city
        function updateZipCode(zip) {
          $('#zipInput').val(zip);
        }
      });

      function geocodeAddress() {
        var street = document.getElementById('streetInput').value;
        var zip = document.getElementById('zipInput').value;
        var city = document.getElementById('cityInput').value;
        var address = street + ', ' + zip + ' ' + city + ', Belgium';

        var url =
          'https://nominatim.openstreetmap.org/search?format=json&q=' +
          encodeURIComponent(address) +
          '&countrycodes=be&limit=1';

        fetch(url).then(function(response) {
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