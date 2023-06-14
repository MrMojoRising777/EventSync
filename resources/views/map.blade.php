<!DOCTYPE html>
<html>
  <head>
    <title>Map</title>
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
  @extends('layouts.app')
  
  @section('content')
    <div class="card">
      <div class="card-body">
        <form>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="streetInput">Straat:</label>
              <input id="streetInput" class="form-control" type="text" placeholder="Geef een straatnaam" />
            </div>
            <div class="col-md-4 mb-3">
              <label for="zipInput">Postcode:</label>
              <input id="zipInput" class="form-control" type="text" placeholder="Geef een postcode" />
            </div>
            <div class="col-md-4 mb-3">
              <label for="cityInput">Stad:</label>
              <input id="cityInput" class="form-control" type="text" placeholder="Geef een stad" />
            </div>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" onclick="geocodeAddress()">Zoek</button>
          </div>
        </form>
      </div>
    </div>

    @include('components.mapComp')
  @endsection
  </body>
</html>