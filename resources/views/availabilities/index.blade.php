@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <style>
        .checkbox-wrapper-12 {
            position: relative;
            display: flex;
            align-items: center;
        }

        .checkbox-wrapper-12 > svg {
            position: absolute;
            top: -130%;
            left: -170%;
            width: 110px;
            pointer-events: none;
        }

        .checkbox-wrapper-12 * {
            box-sizing: border-box;
        }

        .checkbox-wrapper-12 input[type="checkbox"] {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            -webkit-tap-highlight-color: transparent;
            cursor: pointer;
            margin: 0;
        }

        .checkbox-wrapper-12 input[type="checkbox"]:focus {
            outline: 0;
        }

        .checkbox-wrapper-12 .cbx {
            width: 24px;
            height: 24px;
            top: calc(100px - 12px);
            left: calc(100px - 12px);
            margin-right: 10px;
            margin-bottom: 5px;
        }

        .checkbox-wrapper-12 .cbx input {
            position: absolute;
            top: 0;
            left: 0;
            width: 24px;
            height: 24px;
            border: 2px solid #ffa500;
            border-radius: 50%;
        }

        .checkbox-wrapper-12 .cbx label {
            width: 24px;
            height: 24px;
            background: none;
            border-radius: 50%;
            position: absolute;
            top: 0;
            left: 0;
            transform: trasnlate3d(0, 0, 0);
            pointer-events: none;
        }

        .checkbox-wrapper-12 .cbx svg {
            position: absolute;
            top: 5px;
            left: 4px;
            z-index: 1;
            pointer-events: none;
        }

        .checkbox-wrapper-12 .cbx svg path {
            stroke: #fff;
            stroke-width: 3;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 19;
            stroke-dashoffset: 19;
            transition: stroke-dashoffset 0.3s ease;
            transition-delay: 0.2s;
        }

        .checkbox-wrapper-12 .cbx input:checked + label {
            animation: splash-12 0.6s ease forwards;
        }

        .checkbox-wrapper-12 .cbx input:checked + label + svg path {
            stroke-dashoffset: 0;
        }

        @-moz-keyframes splash-12 {
            40% {
                background: #ffa500;
                box-shadow: 0 -18px 0 -8px #ffa500, 16px -8px 0 -8px #ffa500, 16px 8px 0 -8px #ffa500, 0 18px 0 -8px #ffa500, -16px 8px 0 -8px #ffa500, -16px -8px 0 -8px #ffa500;
            }

            100% {
                background: #ffa500;
                box-shadow: 0 -36px 0 -10px transparent, 32px -16px 0 -10px transparent, 32px 16px 0 -10px transparent, 0 36px 0 -10px transparent, -32px 16px 0 -10px transparent, -32px -16px 0 -10px transparent;
            }
        }

        @-webkit-keyframes splash-12 {
            40% {
                background: #ffa500;
                box-shadow: 0 -18px 0 -8px #ffa500, 16px -8px 0 -8px #ffa500, 16px 8px 0 -8px #ffa500, 0 18px 0 -8px #ffa500, -16px 8px 0 -8px #ffa500, -16px -8px 0 -8px #ffa500;
            }

            100% {
                background: #ffa500;
                box-shadow: 0 -36px 0 -10px transparent, 32px -16px 0 -10px transparent, 32px 16px 0 -10px transparent, 0 36px 0 -10px transparent, -32px 16px 0 -10px transparent, -32px -16px 0 -10px transparent;
            }
        }

        @-o-keyframes splash-12 {
            40% {
                background: #ffa500;
                box-shadow: 0 -18px 0 -8px #ffa500, 16px -8px 0 -8px #ffa500, 16px 8px 0 -8px #ffa500, 0 18px 0 -8px #ffa500, -16px 8px 0 -8px #ffa500, -16px -8px 0 -8px #ffa500;
            }

            100% {
                background: #ffa500;
                box-shadow: 0 -36px 0 -10px transparent, 32px -16px 0 -10px transparent, 32px 16px 0 -10px transparent, 0 36px 0 -10px transparent, -32px 16px 0 -10px transparent, -32px -16px 0 -10px transparent;
            }
        }

        @keyframes splash-12 {
            40% {
                background: #ffa500;
                box-shadow: 0 -18px 0 -8px #ffa500, 16px -8px 0 -8px #ffa500, 16px 8px 0 -8px #ffa500, 0 18px 0 -8px #ffa500, -16px 8px 0 -8px #ffa500, -16px -8px 0 -8px #ffa500;
            }

            100% {
                background: #ffa500;
                box-shadow: 0 -36px 0 -10px transparent, 32px -16px 0 -10px transparent, 32px 16px 0 -10px transparent, 0 36px 0 -10px transparent, -32px 16px 0 -10px transparent, -32px -16px 0 -10px transparent;
            }
        }

        .available-day {
            background-color: #FCCB8F;
        }

    </style>

    <div class="card">
        <div class="card-body">
            <h1 class="card-header">Availabilities</h1>
            <div class="container">
                <h2>Owned events:</h2>
                <ul>
                    @foreach ($ownedEvents as $ownedevent)
                    <div class="checkbox-wrapper-12">
                        <div class="cbx">
                            <input id="cbx-12" type="checkbox" class="event-checkbox" value="{{ $ownedevent->id }}">
                            <label for="cbx-12"></label>
                            <svg width="15" height="14" viewBox="0 0 15 14" fill="none">
                            <path d="M2 8.36364L6.23077 12L13 2"></path>
                            </svg>
                        </div>
                        <span><strong>Event Name: </strong>{{ $ownedevent->name }}</span> 
                        
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
                            <defs>
                            <filter id="goo-12">
                                <feGaussianBlur in="SourceGraphic" stdDeviation="4" result="blur"></feGaussianBlur>
                                <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 22 -7" result="goo-12"></feColorMatrix>
                                <feBlend in="SourceGraphic" in2="goo-12"></feBlend>
                            </filter>
                            </defs>
                        </svg>
                    </div>
                    @endforeach
                </ul>
                <br>
                <h2>Invited events:</h2>
                <ul>
                    @foreach ($events as $event)
                        <div class="checkbox-wrapper-12">
                            <div class="cbx">
                                <input id="cbx-12" type="checkbox" class="event-checkbox" value="{{ $ownedevent->id }}">
                                <label for="cbx-12"></label>
                                <svg width="15" height="14" viewBox="0 0 15 14" fill="none">
                                <path d="M2 8.36364L6.23077 12L13 2"></path>
                                </svg>
                            </div>
                            <strong>Event Name:</strong> {{ $event->name }}    
                            
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
                                <defs>
                                <filter id="goo-12">
                                    <feGaussianBlur in="SourceGraphic" stdDeviation="4" result="blur"></feGaussianBlur>
                                    <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 22 -7" result="goo-12"></feColorMatrix>
                                    <feBlend in="SourceGraphic" in2="goo-12"></feBlend>
                                </filter>
                                </defs>
                            </svg>
                        </div>
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
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/nl.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function () {
            // Set moment.js locale to Dutch
            // moment.locale('nl');

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

                    // Check if the event date exists in $availabilities
                    var eventDate = event.start.format('YYYY-MM-DD');
                    var availabilityDates = {!! json_encode($availabilities->pluck('start_date')) !!};
                    console.log(availabilityDates);
                    availabilityDates.forEach(function (date) {
                        var dayElement = $('.fc-day[data-date="' + date + '"]');
                        dayElement.addClass('available-day');
                    });
                },
                selectable: true,
                selectHelper: true,
                eventColor: '#ffa500',

                // disable selecting past dates
                selectAllow: function (selectInfo) {
                    var today = moment().startOf('day');
                    var selectedStartDate = selectInfo.start.startOf('day');
                    // Only allow selection of future dates
                    return selectedStartDate.isSameOrAfter(today);
                },
                // select callback for capturing the selected date
                select: function(startDate, endDate) {
                    var selectedDate = startDate.format('YYYY-MM-DD');
                    
                    // Check if the clicked date is already selected
                    var index = selectedDates.indexOf(selectedDate);
                    if (index !== -1) {
                        // Deselect the date
                        selectedDates.splice(index, 1);
                        $('.fc-day[data-date="' + selectedDate + '"]').removeClass('available-day');
                        console.log('Deselected Date:', selectedDate);
                    } else {
                        // Select the date
                        selectedDates.push(selectedDate);
                        $('.fc-day[data-date="' + selectedDate + '"]').addClass('available-day');
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
                    // Prepare the data to be sent in the AJAX request
                    var requestData = {
                        event_id: eventId,
                        start_date: selectedDates,
                        end_date: selectedDates,
                    };

                    // Send the AJAX request with the data
                    $.ajax({
                        url: SITEURL + "/availabilities/store",
                        type: "POST",
                        data: requestData,
                        success: function (response) {
                            toastr.success('Availability added for ' + eventId);
                            console.log('Response for Event ID ' + eventId + ':', requestData);
                            // Handle the response from the server
                        },
                        error: function (error) {
                            toastr.log('Oops! Something went wrong.')
                            console.log('Error for Event ID ' + eventId + ':', error);
                            // Handle the error
                        }
                    });
                });
            });

        });
    </script>
@endsection