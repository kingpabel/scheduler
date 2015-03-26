@extends('User.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Event Report
            </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <a style="text-decoration: none" href="{!! URL::to('/') !!}"> Dashboard</a> /
                    <a style="text-decoration: none" href="{!! URL::to('user/table-report') !!}"> Event Report</a>
                </li>
            </ol>
        </div>
    </div>

    <div class="row" >
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-edit fa-fw"></i> Event Search</h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(array('id' => 'event', 'accept-charset' => 'utf-8', 'class' => 'form-horizontal', 'method' => 'post', 'url' => 'user/calender-report')) !!}
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Start Time</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control from" name="start" required placeholder="Start Time" style="width: 60%">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">End Time</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control to" name="end" required placeholder="End Time" style="width: 60%">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Report</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('asset')
    <style>
        .from {position: relative; z-index:10000;}
        .to {position: relative; z-index:10000;}
        .ui-pnotify{z-index:1041}
    </style>
    <script>
        $(document).ready(function() {
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
        });
    </script>
    @if(Session::get('error'))
        <script type="text/javascript" language="javascript" class="init">
            $(document).ready(function() {
                $.pnotify.defaults.styling = "bootstrap3";
                $.pnotify({
                    title: 'ERROR',
                    text: "{!! Session::get('error') !!}",
                    type: 'error',
                    delay: 3000
                });
            });
        </script>
    @endif
@endsection