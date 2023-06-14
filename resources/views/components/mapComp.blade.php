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
        zoom: 10 // Adjust the zoom level as needed
      })
    });

    vectorSource = new ol.source.Vector();

    var vectorLayer = new ol.layer.Vector({
      source: vectorSource
    });

    map.addLayer(vectorLayer);

    // Iterate over the response array and create markers
    response.forEach(function(event) {
      console.log('Latitude:', event.lat, 'Longitude:', event.long);
      var lat = event.lat;
      var long = event.long;

      var marker = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat([long, lat])) // Marker coordinates: [longitude, latitude]
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

    // Fit the view to the extent of the vector source with padding
    map.getView().fit(vectorSource.getExtent(), { padding: [50, 50, 50, 50] });
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