<!DOCTYPE html>
<html>
  <head>
    <title>Map Example</title>
    <link rel="stylesheet" href="https://openlayers.org/en/v6.6.1/css/ol.css" />
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
            center: ol.proj.fromLonLat([4.663889, 50.641111]), // Center on Belgium coordinates: [longitude, latitude]
            zoom: 10 // Adjust the zoom level as needed
          })
        });

        // Create a marker overlay
        marker = new ol.Feature({
          geometry: new ol.geom.Point(ol.proj.fromLonLat([4.663889, 50.641111])) // Marker coordinates: [longitude, latitude]
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