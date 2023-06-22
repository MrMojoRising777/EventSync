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