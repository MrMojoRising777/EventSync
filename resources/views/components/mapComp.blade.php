<div class="card">
  <div class="card-body">
      <!-- Map container -->
      <div id="map" style="height: 400px;"></div>
  </div>
</div>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/ol/dist/ol.js"></script>
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
      // Emit event with latitude and longitude
      window.dispatchEvent(new CustomEvent('coordinates-updated', { detail: { latitude: lonLat[0], longitude: lonLat[1] } }));
    });

    map.addLayer(vectorLayer);
  }

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
            q: request.term,
            format: 'json',
            addressdetails: 1,
            countrycodes: 'be', // Limit the search to Belgium
            limit: 5
          },
          success: function(data) {
            var uniqueStreets = getUniqueStreets(data);
            response($.map(uniqueStreets, function(item) {
              var address = item.address;
              var street = address.road || '';
              var city = address.city || address.town || address.village || address.hamlet;
              var zip = address.postcode || '';
              return {
                label: street + ', ' + city,
                value: street + ', ' + city,
                zip: zip,
                city: city // Added city property
              };
            }));
          }
        });
      },
      minLength: 2,
      select: function(event, ui) {
        updateZipCode(ui.item.zip);
        updateCity(ui.item.city);
      }
    });

    // get unique streets from Nominatim API
    function getUniqueStreets(data) {
      var uniqueStreets = [];
      var streetsMap = new Map();

      data.forEach(function(item) {
        var address = item.address;
        var street = address.road || '';

        if (street && !streetsMap.has(street)) {
          streetsMap.set(street, true);
          uniqueStreets.push(item);
        }
      });

      return uniqueStreets;
    }

    // update zip code
    function updateZipCode(zip) {
      $('#zipInput').val(zip);
    }

    // update city
    function updateCity(city) {
      $('#cityInput').val(city);
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

    var searchButton = document.querySelector('.btn-primary');
    searchButton.addEventListener('click', function(event) {
      event.preventDefault();
      geocodeAddress();
    });
  });
</script>