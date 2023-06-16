@extends('layouts.app')

@section('content')
    <h1>Add New Availability</h1>

    <form method="POST" action="{{ route('availabilities.store') }}">
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        
        <label>Event:</label>
        @if ($events->isEmpty())
            <p>No events available.</p>
        @else
            <select name="event_id">
                @foreach ($events as $event)
                    <option value="{{ $event->id }}">{{ $event->name }}</option>
                @endforeach
            </select>
        @endif

        <label>Start Date:</label>
        <input type="date" name="start_date">

        <label>End Date:</label>
        <input type="date" name="end_date">

        <button type="submit">Add</button>
    </form>
@endsection
