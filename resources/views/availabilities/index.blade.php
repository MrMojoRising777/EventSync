@extends('layouts.app')

@section('content')
    <h1>Availabilities</h1>

    <a href="{{ route('availabilities.create') }}">Add New Availability</a>

    <table>
        <tr>
            <th>User</th>
            <th>Event</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Action</th>
        </tr>
        @foreach ($availabilities as $availability)
            <tr>
                <td>{{ $availability->user->name }}</td>
                <td>{{ $availability->event->name }}</td>
                <td>{{ $availability->start_date }}</td>
                <td>{{ $availability->end_date }}</td>
                <td>
                    <a href="{{ route('availabilities.edit', $availability->id) }}">Edit</a>
                    <form method="POST" action="{{ route('availabilities.destroy', $availability->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
