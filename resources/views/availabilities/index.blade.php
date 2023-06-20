@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <h1>Availabilities</h1>

    <a href="{{ route('availabilities.create') }}">Add New Availability</a>

    <div class="container mt-5" style="max-width: 700px">
        <div id="full_calendar_events"></div>
        <button id="save-button" class="btn btn-primary mt-3">Save</button>
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
                    // Add the selected date to the array
                    selectedDates.push(selectedDate);
                    console.log('Selected Date:', selectedDate);
                    // Highlight the selected date on the calendar
                    calendar.fullCalendar('renderEvent', {
                        start: startDate,
                        end: endDate,
                        rendering: 'background',
                        className: 'fc-highlight'
                    });
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
                // Send the selectedDates array to the server
                $.ajax({
                    url: SITEURL + "/availabilities/store",
                    type: "POST",
                    data: {
                        event_id: 4, // HARDCODED
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

        function displayMessage(message) {
            toastr.success(message, 'Event');
        }
    </script>
@endsection
