<!-- availabilities/show.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Availability Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">User: {{ $availability->user->name }}</h5>
            <p class="card-text">Start Time: {{ $availability->start_time }}</p>
            <p class="card-text">End Time: {{ $availability->end_time }}</p>
            <a href="{{ route('availabilities.index') }}" class="btn btn-primary">Back</a>
        </div>
    </div>
@endsection
