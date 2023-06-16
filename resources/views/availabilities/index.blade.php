<!-- availabilities/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Availabilities</h1>

    <a href="{{ route('availabilities.create') }}" class="btn btn-primary mb-3">Add Availability</a>

    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($availabilities as $availability)
                <tr>
                    <td>{{ $availability->user->name }}</td>
                    <td>{{ $availability->start_time }}</td>
                    <td>{{ $availability->end_time }}</td>
                    <td>
                        <a href="{{ route('availabilities.show', $availability->id) }}" class="btn btn-sm btn-primary">View</a>
                        <a href="{{ route('availabilities.edit', $availability->id) }}" class="btn btn-sm btn-success">Edit</a>
                        <form action="{{ route('availabilities.destroy', $availability->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this availability?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection