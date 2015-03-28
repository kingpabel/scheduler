{!!
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
!!}
@extends('User.layout')
@section('content')
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Dashboard
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <a style="text-decoration: none" href="{!! URL::to('/') !!}"> Dashboard</a>
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{!! $monthEvent !!}</div>
                                    <div>Event! This Month</div>
                                </div>
                            </div>
                        </div>
                        <a href="{!! URL::to('user/event') !!}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{!! $lastMonthEvent !!}</div>
                                    <div>Event! Last Month</div>
                                </div>
                            </div>
                        </div>
                        <a href="{!! URL::to('user/event') !!}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div><div class="col-lg-4 col-md-4">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{!! $nextMonthEvent !!}</div>
                                    <div>Event! Next Month</div>
                                </div>
                            </div>
                        </div>
                        <a href="{!! URL::to('user/event') !!}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row" >
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> This Month Individual Day Total Event
                        </div>
                        <div class="panel-body">
                            <div id="morris-bar-chart"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
            </div>
            <div class="row" >
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Full Year Individual Month Report
                        </div>
                        <div class="panel-body">
                            <div id="piechart" style="width: 100%;height: 400px;font-size: 11px;"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
            </div>
@endsection
@section('asset')
    {!! HTML::script('js/googleChart.js') !!}
    {!! HTML::style('css/morris.css') !!}
    {!! HTML::script('js/raphael-min.js') !!}
    {!! HTML::script('js/morris.min.js') !!}
    {{--{!! HTML::script('js/morris-data.js') !!}--}}
        <script type="text/javascript" language="javascript" class="init">
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Month', 'Total Event'],
                        @foreach($fullYearMonthEvent as $yearMonthEvent)
                    ["{!! date('m-Y', strtotime($yearMonthEvent->start_time)).'('.$yearMonthEvent->total.')' !!}",     {!! $yearMonthEvent->total !!}],
                    @endforeach
                ]);

                var options = {
                    title: 'Full Year Individual Month Report'
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
            }
            $(function() {
                Morris.Bar({
                    element: 'morris-bar-chart',
                    data: [
                            @foreach($fullMonthEvent as $MonthEvent)
                        {
                        y: "{!! date('Y-m-d', strtotime($MonthEvent->start_time)) !!}",
                        a: "{!! $MonthEvent->total !!}"
                         },
                        @endforeach
                    ],
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['Total Event This Day'],
                    hideHover: 'auto',
                    resize: true
                });
            });
        </script>
    @if(Session::get('success'))
        <script type="text/javascript" language="javascript" class="init">
            $(document).ready(function() {
                $.pnotify.defaults.styling = "bootstrap3";
                $.pnotify({
                    title: 'Message',
                    text: "{!! Session::get('success') !!}",
                    type: 'success',
                    delay: 3000
                });
            });
        </script>
    @endif
@endsection

