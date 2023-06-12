@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card">
          <div class="card-header">
            <h2>{{ __('Dashboard') }}</h2>
          </div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            <h4>{{ __('Welkom, :name', ['name' => Auth::user()->username]) }}</h4>

            <div class="dashboard-container">
              <div class="row">
                <div class="col-lg-2">

                  <div class="card friends-container">
                    <div class="card-header">{{ __('Vrienden') }}</div>
                    <div class="card-body">
                      <ul>
                        @foreach ($usersArray as $friend)
                          <li>{{ $friend->username }}</li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>

              <div class="col-lg-10">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="card calendar-container">
                      <div class="card-header">{{ __('Geplande activiteiten') }}</div>
                      <div class="card-body">
                        <!-- Calendar Component -->
                        @include('components.calendar')
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="card map-container">
                      <div class="card-header">{{ __('Map') }}</div>
                        <div class="card-body">
                          <!-- Map Component -->
                          @include('components.mapComp')
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection