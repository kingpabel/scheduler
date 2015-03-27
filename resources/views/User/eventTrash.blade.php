@extends('User.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Event Trash
            </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <a style="text-decoration: none" href="{!! URL::to('/') !!}"> Dashboard</a> /
                    <a style="text-decoration: none" href="{!! URL::to('user/event-trash') !!}"> Event Trash</a>
                </li>
            </ol>
        </div>
    </div>
    <?php if(!($events->isEmpty())): ?>
    <div class="row">
        <div class="col-lg-12">
            <a href="{!! URL::to('user/event-all-restore') !!}" class="btn btn-success">Restore All Trash</a>
            <a href="{!! URL::to('user/event-all-delete') !!}" class="btn btn-danger btn-large">Delete All Trash</a>
        </div>
    </div>
<br/>
    <?php endif ?>
    <!-- /.row -->
    <div class="row" ng-app="event" ng-controller="eventDeleteController">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-fw fa-table fa-fw"></i> My Event Trash</h3>
                </div>
                <div class="panel-body">
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $event)
                            <tr id="{!! $event->id !!}">
                                <td>{!! $event->title !!}</td>
                                <td>{!! $event->start_time !!}</td>
                                <td>{!! $event->end_time !!}</td>
                                <td>
                                    <a class="btn btn-success delete" ng-click="restore({!! $event->id !!})" ><i class="fa fa-fw fa-reply"></i>Restore</a>
                                    <a class="btn btn-danger delete" ng-click="delete({!! $event->id !!})" ><i class="fa fa-fw fa-trash-o"></i>Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('asset')
    {!! HTML::script('js/jquery.dataTables.js') !!}
    {!! HTML::script('js/dataTables.tableTools.js') !!}
    {!! HTML::style('css/jquery.dataTables.css') !!}
    {!! HTML::style('css/dataTables.tableTools.css') !!}
    <script>
        var event = angular.module('event', [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('{kp');
            $interpolateProvider.endSymbol('kp}');
        });
        event.controller('eventDeleteController',function($scope,$http){
            $scope.restore = function(id){
                var req = {
                    method : 'GET',
                    url : "{!! URL::to('user/restore-event') !!}",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    params: { id: id }
                };
                    $http(req).success(function (response) {
                        $.pnotify.defaults.styling = "bootstrap3";
                        if (response == 'true') {
                            $("#"+id).hide();
                            $.pnotify({
                                title: 'Message',
                                text: 'Event Restored Successfully',
                                type: 'success',
                                delay: 3000
                            });
                        } else {
                            $.pnotify({
                                title: 'ERROR',
                                text: 'Something Went Wrong',
                                type: 'error',
                                delay: 3000
                            });
                        }
                    });
            };

            $scope.delete = function(id){
                var req = {
                    method : 'GET',
                    url : "{!! URL::to('user/delete-event') !!}",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    params: { id: id }
                };
                var chk = confirm("Are you sure to delete this?");
                if (chk) {
                    $http(req).success(function (response) {
                        $.pnotify.defaults.styling = "bootstrap3";
                        if (response == 'true') {
                            $("#"+id).hide();
                            $.pnotify({
                                title: 'Message',
                                text: 'Event Deleted Successfully',
                                type: 'success',
                                delay: 3000
                            });
                        } else {
                            $.pnotify({
                                title: 'ERROR',
                                text: 'Something Went Wrong',
                                type: 'error',
                                delay: 3000
                            });
                        }
                    });
                }
            };
        });
    </script>
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'T<"clear">lfrtip',
                oTableTools : {
                    "aButtons": [
                        "copy",
                        "print"
                    ]
                }
            });
        });
    </script>
@endsection