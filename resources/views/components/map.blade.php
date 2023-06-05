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
    </style>
  </head>
  <body>
    <div>
      <input id="addressInput" type="text" placeholder="Enter an address" />
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
        var address = document.getElementById('addressInput').value;
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