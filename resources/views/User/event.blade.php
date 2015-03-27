@extends('User.layout')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
           My Event
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a style="text-decoration: none" href="{!! URL::to('/') !!}"> Dashboard</a> /
                <a style="text-decoration: none" href="{!! URL::to('user/event') !!}"> Event</a>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-fw fa-th fa-fw"></i> My Event</h3>
            </div>
            <div class="panel-body">
                <div id='calendar'>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="calEventDialog" title="Create an Event">
    <form class="form-horizontal">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="csrf">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Title</label>
            <div class="col-sm-10">
                <input type="title" id="title" name="title" class="form-control"placeholder="Title" value="">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Start</label>
            <div class="col-sm-10">
                <input type="text" id="from" name="start_time" readonly class="form-control datepicker from" placeholder="Start Time">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">End</label>
            <div class="col-sm-10">
                <input type="text" id="to" name="end_time" readonly class="form-control datepicker2 to" placeholder="End Time">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="button" id="saveCalender" class="btn btn-default"><i class="fa fa-fw fa-plus"></i> Create</button>
            </div>
        </div>
    </form>
</div>


<div id="editEvent" title="Update an Event">
    <form class="form-horizontal">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="csrf">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Title</label>
            <div class="col-sm-10">
                <input type="title" id="editTitle" name="editTitle" class="form-control"placeholder="Title">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Start</label>
            <div class="col-sm-10">
                <input type="text" id="editStart" name="editStart" readonly class="form-control datepicker from" placeholder="Start Time">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">End</label>
            <div class="col-sm-10">
                <input type="text" id="editEnd" name="editEnd" readonly class="form-control datepicker2 to" placeholder="End Time">
                <input type="hidden" id="editID" name="editID"  class="form-control datepicker2" placeholder="End Time">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="button" id="updateEvent" class="btn btn-default"><i class="fa fa-fw fa-edit"></i> Update</button>
            </div>
        </div>
    </form>
</div>
    @endsection
@section('asset')
    <style>
        .from {position: relative; z-index:10000;}
        .to {position: relative; z-index:10000;}
        .ui-pnotify{z-index:1041}
    </style>
    {!! HTML::style('css/fullcalendar.css') !!}
    <link href="{!! URL::to('css/fullcalendar.print.css') !!}" rel='stylesheet' media='print' />
    {!! HTML::script('js/moment.min.js') !!}
    {!! HTML::script('js/fullcalendar.min.js') !!}


    <script>
        $(document).ready(function() {
            $("#saveCalender").click(function() {
                var title = $("#title").val();
                var start = $("#from").val();
                var end = $("#to").val();
                var eventData;
                if (title && start && end) {
                    $.ajax({
                        url: '{!! URL::to("user/save-event") !!}',
                        type: "GET",
//                        dataType: 'JSON',
                        data: {title: title, start:start, end:end},
                        cache: false,
                        success: function(data) {
                            if(data.type == 'success') {
                                $.pnotify.defaults.styling = "bootstrap3";
                                $.pnotify({
                                    title: 'Success',
                                    text: 'A New Event Created',
                                    type: 'success',
                                    delay: 3000
                                });
                                eventData = {
                                    id : parseInt(data.data),
                                    title: title,
                                    start: start,
                                    end: end
                                };
                                $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                                $('#calendar').fullCalendar('unselect');
                                $('#calEventDialog').dialog('close');
                            }else{
                                $.pnotify.defaults.styling = "bootstrap3";
                                $.pnotify({
                                    title: 'ERROR',
                                    text: data.data,
                                    type: 'error',
                                    delay: 3000
                                });
                            }
                        }
                    });
                }else{
                    $.pnotify.defaults.styling = "bootstrap3";
                    $.pnotify({
                        title: 'ERROR',
                        text: 'Please Fill All The Fields',
                        type: 'error',
                        delay: 3000
                    });
                }
            });
            $("#updateEvent").click(function() {
                var title = $("#editTitle").val();
                var start = $("#editStart").val();
                var end = $("#editEnd").val();
                var id = $("#editID").val();
                var eventData;
                if (title && start && end && id) {
                    $.ajax({
                        url: '{!! URL::to("user/update-event") !!}',
                        type: "GET",
                        data: {title: title, start:start, end:end, id:id},
                        cache: false,
                        success: function(data) {
                            if(data == 'true') {
                                $.pnotify.defaults.styling = "bootstrap3";
                                $.pnotify({
                                    title: 'Success',
                                    text: 'Event Updated',
                                    type: 'success',
                                    delay: 3000
                                });
                                eventData = {
                                    id: id,
                                    title: title,
                                    start: start,
                                    end: end
                                };
                                $('#calendar').fullCalendar('removeEvents',[eventData.id]);
                                $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                                $('#calendar').fullCalendar('unselect');
                                $('#editEvent').dialog('close');
                            }else{
                                $.pnotify.defaults.styling = "bootstrap3";
                                $.pnotify({
                                    title: 'ERROR',
                                    text: data,
                                    type: 'error',
                                    delay: 3000
                                });
                            }
                        }
                    });
                }else{
                    $.pnotify.defaults.styling = "bootstrap3";
                    $.pnotify({
                        title: 'ERROR',
                        text: 'Please Fill All The Fields',
                        type: 'error',
                        delay: 3000
                    });
                }
            });
            // init first
            $('#calEventDialog').dialog({autoOpen: false});
            $('#editEvent').dialog({autoOpen: false});
            $( ".from" ).datetimepicker({
                dateFormat:'yy-mm-dd',
                defaultDate: "+1w",
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                    $( ".to" ).datepicker( "option", "minDate", selectedDate );
                }
            });
            $( ".to" ).datetimepicker({
                dateFormat:'yy-mm-dd',
                defaultDate: "+1w",
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                    $( ".from" ).datepicker( "option", "maxDate", selectedDate );
                }
            });

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultDate: "<?php echo date('Y-m-d')?>",
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
                    $("#title").val('');
                    $("#from").val(dateFormat(start, "yyyy-mm-dd 00:00"));
                    $("#to").val(dateFormat(end, "yyyy-mm-dd 00:00"));
                    $('#calEventDialog').dialog('open');
                },
                eventClick: function(event, element) {
                    $("#editTitle").val(event.title);
                    $("#editID").val(event.id);
                    $("#editStart").val(event.start._i);
                    $("#editEnd").val(event.end._i);
                    $('#editEvent').dialog('open');
                    console.log(event);
                },
                //editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: [
                        @foreach($events as $event)
                    {
                        id : "{!! $event->id !!}",
                        title: "{!! $event->title !!}",
                        start: "{!! date('Y-m-d H:i', strtotime($event->start_time )) !!}",
                        end: "{!! date('Y-m-d H:i', strtotime($event->end_time )) !!}"
                    },
                        @endforeach

                ]
            });
            <?php
            if (Session::has('success')){
            ?>
            $.pnotify.defaults.styling = "bootstrap3";
            $.pnotify({
                title: 'Message',
                text: "<?php echo Session::get('success')?>",
                type: 'success',
                delay: 3000
            });
           <?php }
            ?>

        });
        var dateFormat = function () {
            var token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
                    timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
                    timezoneClip = /[^-+\dA-Z]/g,
                    pad = function (val, len) {
                        val = String(val);
                        len = len || 2;
                        while (val.length < len) val = "0" + val;
                        return val;
                    };

            // Regexes and supporting functions are cached through closure
            return function (date, mask, utc) {
                var dF = dateFormat;

                // You can't provide utc if you skip other args (use the "UTC:" mask prefix)
                if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
                    mask = date;
                    date = undefined;
                }

                // Passing date through Date applies Date.parse, if necessary
                date = date ? new Date(date) : new Date;
                if (isNaN(date)) throw SyntaxError("invalid date");

                mask = String(dF.masks[mask] || mask || dF.masks["default"]);

                // Allow setting the utc argument via the mask
                if (mask.slice(0, 4) == "UTC:") {
                    mask = mask.slice(4);
                    utc = true;
                }

                var _ = utc ? "getUTC" : "get",
                        d = date[_ + "Date"](),
                        D = date[_ + "Day"](),
                        m = date[_ + "Month"](),
                        y = date[_ + "FullYear"](),
                        H = date[_ + "Hours"](),
                        M = date[_ + "Minutes"](),
                        s = date[_ + "Seconds"](),
                        L = date[_ + "Milliseconds"](),
                        o = utc ? 0 : date.getTimezoneOffset(),
                        flags = {
                            d:    d,
                            dd:   pad(d),
                            ddd:  dF.i18n.dayNames[D],
                            dddd: dF.i18n.dayNames[D + 7],
                            m:    m + 1,
                            mm:   pad(m + 1),
                            mmm:  dF.i18n.monthNames[m],
                            mmmm: dF.i18n.monthNames[m + 12],
                            yy:   String(y).slice(2),
                            yyyy: y,
                            h:    H % 12 || 12,
                            hh:   pad(H % 12 || 12),
                            H:    H,
                            HH:   pad(H),
                            M:    M,
                            MM:   pad(M),
                            s:    s,
                            ss:   pad(s),
                            l:    pad(L, 3),
                            L:    pad(L > 99 ? Math.round(L / 10) : L),
                            t:    H < 12 ? "a"  : "p",
                            tt:   H < 12 ? "am" : "pm",
                            T:    H < 12 ? "A"  : "P",
                            TT:   H < 12 ? "AM" : "PM",
                            Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
                            o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
                            S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
                        };

                return mask.replace(token, function ($0) {
                    return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
                });
            };
        }();

        // Some common format strings
        dateFormat.masks = {
            "default":      "ddd mmm dd yyyy HH:MM:ss",
            shortDate:      "m/d/yy",
            mediumDate:     "mmm d, yyyy",
            longDate:       "mmmm d, yyyy",
            fullDate:       "dddd, mmmm d, yyyy",
            shortTime:      "h:MM TT",
            mediumTime:     "h:MM:ss TT",
            longTime:       "h:MM:ss TT Z",
            isoDate:        "yyyy-mm-dd",
            isoTime:        "HH:MM:ss",
            isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
            isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
        };

        // Internationalization strings
        dateFormat.i18n = {
            dayNames: [
                "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
                "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
            ],
            monthNames: [
                "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
                "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
            ]
        };

        // For convenience...
        Date.prototype.format = function (mask, utc) {
            return dateFormat(this, mask, utc);
        };
    </script>
    <style>
        #calendar {
            font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
            font-size: 14px;
            max-width: 900px;
            margin: 0 auto;
            margin-left: 0px;
            max-width: 1050px !important;
        }
    </style>
    @endsection