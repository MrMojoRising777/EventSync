<div class="card">
  <div class="card-body">
    <form>
      <!-- Form inputs and button -->

      <!-- Map container -->
      <div id="map" style="height: 400px;"></div>
    </form>
  </div>
</div>

<!-- Inline styles -->
<style>
  /* Styles */
</style>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/ol/dist/ol.js"></script>
<script>
  // Initialize the map
  var map;
  var marker;
  var vectorSource;

  function initMap() {
    map = new ol.Map({
      target: 'map',
      layers: [
        new ol.layer.Tile({
          source: new ol.source.OSM()
        })
      ],
      view: new ol.View({
        center: ol.proj.fromLonLat([5.5368901, 50.995]),
        zoom: 10
      })
    });

    // Rest of the map initialization code...
  }

  // Call the initMap function once the DOM content is loaded
  document.addEventListener('DOMContentLoaded', function() {
    initMap();
  });
</script>