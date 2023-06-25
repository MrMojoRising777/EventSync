<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fullcalender Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>
<body>
    <div class="container mt-2">
        <div id='full_calendar_events'></div>
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

            var calendar = $('#full_calendar_events').fullCalendar({
                editable: true,
                displayEventTime: true,
                // contentHeight: 436,
                // aspectRatio: 1.35,
                handleWindowResize: true,
                eventRender: function (event, element, view) {
                    element.find('.fc-title').text(event.title);
                },
                selectable: true,
                selectHelper: true,
                eventColor: '#ffa500',

                // select callback for capturing selected date
                select: function(startDate, endDate) {
                    var selectedDate = startDate.format('YYYY-MM-DD');
                    // Emit event with event date
                    window.dispatchEvent(new CustomEvent('date-updated', { detail: { date: selectedDate } }));
                },

                // disable selecting past dates
                selectAllow: function (selectInfo) {
                    var today = moment().startOf('day');
                    var selectedStartDate = selectInfo.start.startOf('day');
                    // Only allow selection of future dates
                    return selectedStartDate.isSameOrAfter(today);
                },
                events: function (start, end, timezone, callback) {
                    $.ajax({
                        url: SITEURL + "/calendar",
                        type: "GET",
                        success: function (data) {
                            callback(data); // Pass events directly to callback
                        },
                        error: function () {
                            console.log('Failed to fetch calendar events');
                        }
                    });
                }
            });
        });

        function displayMessage(message) {
            toastr.success(message, 'Event');
        }
    </script>
</body>
</html>