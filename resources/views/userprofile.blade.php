@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">{{ __('Profiel') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>{{ __('Welcome, :name', ['name' => Auth::user()->name]) }}</h4>

                    <div class="dashboard-container">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header">{{ __('Friends') }}</div>
                                    <div class="card-body">
                                        <ul>
                                            <li>Friend 1</li>
                                            <li>Friend 2</li>
                                            <li>Friend 3</li>
                                            <li>Friend 4</li>
                                            <li>Friend 5</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">{{ __('Planned activities') }}</div>
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
@endsection