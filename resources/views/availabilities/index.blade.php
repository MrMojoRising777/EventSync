@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <div class="card">
        <div class="card-body">
            <h1 class="card-header">Availabilities</h1>
            <div class="container">
                <h2>Owned events:</h2>
                <ul>
                    @foreach ($ownedEvents as $ownedevent)
                        <li>
                            <input type="checkbox" class="event-checkbox" value="{{ $ownedevent->id }}">
                            <strong>Event Name:</strong> {{ $ownedevent->name }}
                        </li>
                    @endforeach
                </ul>
                <br>
                <h2>Invited events:</h2>
                <ul>
                    @foreach ($events as $event)
                        <li>
                            <input type="checkbox" class="event-checkbox" value="{{ $event->id }}">
                            <strong>Event Name:</strong> {{ $event->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="container mt-5" style="max-width: 700px">
                <div id="full_calendar_events"></div>
                <button id="save-button" class="btn btn-primary mt-3">Save</button>
            </div>
        </div>
    </div>


    {{-- Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/nl.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function () {
            // Set moment.js locale to Dutch
            moment.locale('nl');

            // fetch header information
            var SITEURL = "{{ url('/') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var selectedDates = []; // Array to store selected dates

            var calendar = $('#full_calendar_events').fullCalendar({
                editable: true,
                displayEventTime: true,
                eventRender: function (event, element, view) {
                    element.find('.fc-title').text(event.title);
                },
                selectable: true,
                selectHelper: true,

                // select callback for capturing the selected date
                select: function(startDate, endDate) {
                    var selectedDate = startDate.format('YYYY-MM-DD');
                    
                    // Check if the clicked date is already selected
                    var index = selectedDates.indexOf(selectedDate);
                    if (index !== -1) {
                        // Deselect the date
                        selectedDates.splice(index, 1);
                        $('.fc-day[data-date="' + selectedDate + '"]').removeClass('fc-highlight');
                        console.log('Deselected Date:', selectedDate);
                    } else {
                        // Select the date
                        selectedDates.push(selectedDate);
                        $('.fc-day[data-date="' + selectedDate + '"]').addClass('fc-highlight');
                        console.log('Selected Date:', selectedDate);
                    }

                    // Deselect the selection
                    calendar.fullCalendar('unselect');
                },
                events: function (start, end, timezone, callback) {
                    $.ajax({
                        url: SITEURL + "/calendar",
                        type: "GET",
                        success: function (data) {
                            callback(data); // Pass the events directly to the callback
                        },
                        error: function () {
                            // Handle error if the AJAX request fails
                            console.log('Failed to fetch calendar events');
                        }
                    });
                }
            });

            // Save button click event
            $('#save-button').on('click', function () {
                var selectedEvents = [];
                $('.event-checkbox:checked').each(function () {
                    selectedEvents.push($(this).val());
                });
                console.log(selectedEvents);

                // Iterate over selectedEvents array
                selectedEvents.forEach(function(eventId) {
                    // Send the selectedDates array to the server for each event ID
                    $.ajax({
                        url: SITEURL + "/availabilities/store",
                        type: "POST",
                        data: {
                            event_id: eventId,
                            start_date: selectedDates,
                            end_date: selectedDates,
                        },
                        success: function (response) {
                            console.log('Response:', response);
                            // Handle the response from the server
                        },
                        error: function (error) {
                            console.log('Error:', error);
                            // Handle the error
                        }
                    });
                });
            });
        });
    </script>
@endsection