
@extends('User.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Password Change
            </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <a style="text-decoration: none" href="{!! URL::to('/') !!}"> Dashboard</a> /
                    <a style="text-decoration: none" href="{!! URL::to('user/password-change') !!}"> Change Password</a>
                </li>
            </ol>
        </div>
    </div>

    <div class="row" ng-app="setting" ng-controller="settingController">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-edit fa-fw"></i> Password Change</h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(array('id' => 'passwordChange', 'accept-charset' => 'utf-8', 'class' => 'form-horizontal', 'method' => 'post', 'ng-submit' => 'update($event)')) !!}
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Current Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="current_password" required placeholder="Old Password" style="width: 60%">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">New Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="new_password" required placeholder="New Password" style="width: 60%">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Confirm Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="confirm_password" required placeholder="Confirm Password" style="width: 60%">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Change</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('asset')
    <script>
        var event = angular.module('setting', [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('{kp');
            $interpolateProvider.endSymbol('kp}');
        });
        event.controller('settingController',function($scope,$http){
            $scope.update = function(event){
                event.preventDefault();
                var req = {
                    method : 'POST',
                    url : "{!! URL::to('user/password-change') !!}",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $("#passwordChange").serialize()
                };
                $http(req).success(function (response) {
                    $.pnotify.defaults.styling = "bootstrap3";
                    if (response == 'true') {
                        $.pnotify({
                            title: 'Message',
                            text: 'Password Changed Successfully',
                            type: 'success',
                            delay: 3000
                        });
                    } else {
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
@endsection