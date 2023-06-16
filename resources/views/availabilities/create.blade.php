<!-- availabilities/create.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Add Availability</h1>

    <form action="{{ route('availabilities.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="user_id">User:</label>
            <select class="form-control" id="user_id" name="user_id">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="start_time">Start Time:</label>
            <input type="datetime-local" class="form-control" id="start_time" name="start_time" required>
        </div>

        <div class="form-group">
            <label for="end_time">End Time:</label>
            <input type="datetime-local" class="form-control" id="end_time" name="end_time" required>
        </div>

        <button type="submit" class="btn btn-primary">Add</button>
    </form>
@endsection
