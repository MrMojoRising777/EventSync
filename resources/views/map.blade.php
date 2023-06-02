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
      <div id="map"></div>
      <script src="https://cdn.jsdelivr.net/npm/ol/dist/ol.js"></script>
      <script>
          // Map initialization code
          var map = new ol.Map({
                target: 'map',
                layers: [
                    new ol.layer.Tile({
                        source: new ol.source.OSM()
                    })
                ],
                view: new ol.View({
                    center: ol.proj.fromLonLat([5.536490, 50.994720]), // Genk coordinates: [longitude, latitude]
                    zoom: 13 // Adjust the zoom level as needed
                })
            });

            // Create a marker overlay
            var marker = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.fromLonLat([5.536490, 50.994720])) // Marker coordinates: [longitude, latitude]
            });

            var markerStyle = new ol.style.Style({
                image: new ol.style.Icon({
                    anchor: [0.5, 1], // Set the anchor point of the marker icon
                    src: 'https://openlayers.org/en/latest/examples/data/icon.png' // URL to the marker icon image
                })
            });

            marker.setStyle(markerStyle);

            var vectorSource = new ol.source.Vector({
                features: [marker]
            });

            var vectorLayer = new ol.layer.Vector({
                source: vectorSource
            });

            map.addLayer(vectorLayer);
      </script>
  </body>
</html>