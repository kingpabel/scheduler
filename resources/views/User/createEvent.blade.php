@extends('User.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Create Event
            </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <a style="text-decoration: none" href="{!! URL::to('/') !!}"> Dashboard</a> /
                    <a style="text-decoration: none" href="{!! URL::to('user/create-event') !!}"> Create Event</a>
                </li>
            </ol>
        </div>
    </div>

    <div class="row" ng-app="event" ng-controller="eventDeleteController">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-edit fa-fw"></i> Create Event</h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(array('id' => 'event', 'accept-charset' => 'utf-8', 'class' => 'form-horizontal',  'ng-submit'=>'create($event)')) !!}
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control input" name="title" id="inputEmail3" required placeholder="Title" style="width: 60%">
                        </div>
                    </div>
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
                            <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> Create</button>
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
        var event = angular.module('event', [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('{kp');
            $interpolateProvider.endSymbol('kp}');
        });
        event.controller('eventDeleteController',function($scope,$http){
            $scope.create = function(event){
                event.preventDefault();
                var req = {
                    method : 'POST',
                    url : "{!! URL::to('user/create-event') !!}",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $("#event").serialize()
                };
                $http(req).success(function(response){
                    $.pnotify.defaults.styling = "bootstrap3";
                    if(response == 'true') {
                        window.location.href = "{!! URL::to('user/event') !!}";
                    }else{
                        $.pnotify({
                            title: 'ERROR',
                            text: response,
                            type: 'error',
                            delay: 3000
                        });
                    }
                });
            };
        });
    </script>
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
@endsection