@extends('layouts.app')

@section('content')
    <h1>Edit Availability</h1>

    <form method="POST" action="{{ route('availabilities.update', $availability->id) }}">
        @csrf
        @method('PUT')

        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

        <label>Event:</label>
        @if ($events->isEmpty())
            <p>No events available.</p>
        @else
            <select name="event_id">
                @foreach ($events as $event)
                    <option value="{{ $event->id }}"
                            @if ($availability->event_id == $event->id) selected @endif>
                        {{ $event->name }}
                    </option>
                @endforeach
            </select>
        @endif

        <label>Start Date:</label>
        <input type="date" name="start_date" value="{{ $availability->start_date }}">

        <label>End Date:</label>
        <input type="date" name="end_date" value="{{ $availability->end_date }}">

        <button type="submit">Update</button>
    </form>
@endsection
