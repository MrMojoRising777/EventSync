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

        <div id="date-ranges">
            <div class="date-range">
                <label>Start Date:</label>
                <input type="date" name="start_date[]">

                <label>End Date:</label>
                <input type="date" name="end_date[]">
            </div>
        </div>

        <button type="button" id="add-date-range">Add another date range</button>

        <button type="submit">Add</button>
    </form>
    
    <script>
        document.getElementById('add-date-range').addEventListener('click', function() {
            var dateRangeContainer = document.getElementById('date-ranges');
            var newDateRange = document.createElement('div');
            newDateRange.className = 'date-range';

            var newStartDateLabel = document.createElement('label');
            newStartDateLabel.textContent = 'Start Date:';
            newDateRange.appendChild(newStartDateLabel);

            var newStartDateInput = document.createElement('input');
            newStartDateInput.type = 'date';
            newStartDateInput.name = 'start_date[]';
            newDateRange.appendChild(newStartDateInput);

            var newEndDateLabel = document.createElement('label');
            newEndDateLabel.textContent = 'End Date:';
            newDateRange.appendChild(newEndDateLabel);

            var newEndDateInput = document.createElement('input');
            newEndDateInput.type = 'date';
            newEndDateInput.name = 'end_date[]';
            newDateRange.appendChild(newEndDateInput);

            dateRangeContainer.appendChild(newDateRange);
        });
    </script>
@endsection
