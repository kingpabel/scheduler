
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Kingpabel Scheduler</title>

    {!! HTML::script('js/jquery-2.0.3.min.js') !!}
    <!-- Bootstrap Core CSS -->
    {!! HTML::style('css/bootstrap.min.css') !!}
    {!! HTML::style('css/charisma-app.css') !!}
    {!! HTML::style('css/jquery-ui.css') !!}

    <!-- MetisMenu CSS -->
    {!! HTML::style('css/metisMenu.min.css') !!}

    {{--pnotify--}}
    {!! HTML::style('css/pnotify/jquery.pnotify.default.icons.css') !!}
    {!! HTML::style('css/pnotify/jquery.pnotify.default.css') !!}
    {!! HTML::script('js/pnotify/jquery.pnotify.js') !!}


    {{--{!! HTML::style('colorbox/colorbox.css') !!}
    {!! HTML::script('colorbox/jquery.colorbox.js') !!}--}}

    <!-- Custom CSS -->
    {!! HTML::style('css/sb-admin-2.css') !!}
    {!! HTML::script('js/angular.min.js') !!}

    <!-- Morris Charts CSS -->
    {{--{!! HTML::style('css/plugins/morris.css') !!}--}}

    <!-- Custom Fonts -->
    {!! HTML::style('font-awesome/css/font-awesome.min.css') !!}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        $(function(){
            $(".input").bind("keyup blur",function() {
                var $th = $(this);
                $th.val( $th.val().replace(/[^A-z0-9,. _-]/g, function(str) { return ''; } ) );
            });
        })
        $(function(){
            $(".number").bind("keyup blur",function() {
                var $th = $(this);
                $th.val( $th.val().replace(/[^0-9-.]/g, function(str) { return ''; } ) );
            });
        })
    </script>

    <!--- adsence code from google start-->
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- adsence for kingpabel blog -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-3284345266094241"
         data-ad-slot="6634524410"
         data-ad-format="auto"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <!--- adsence code from google end-->

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-60038966-1', 'auto');
        ga('send', 'pageview');

    </script>
    @yield('asset')
</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://www.kingpabel.com">Kingpabel Blog</a>
        </div>
        <!-- /.navbar-header -->
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>{!! Auth::user()->first_name !!}  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <a href="{!! URL::to('account/logout') !!}"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a class="@if($menu == 'Dashboard') active @endif" href="{!! URL::to('user') !!}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a class="@if($menu == 'Event') active @endif" href="{!! URL::to('user/event') !!}"><i class="fa fa-fw fa-th"></i> Event</a>
                    </li>
                    <li>
                        <a class="@if($menu == 'Create Event') active @endif" href="{!! URL::to('user/create-event') !!}"><i class="fa fa-fw fa-plus"></i>Create Event</a>
                    </li>
                    <li>
                        <a class="@if($menu == 'Table') active @endif" href="{!! URL::to('user/table-event') !!}"><i class="fa fa-fw fa-table"></i>Table Event</a>
                    </li>
                    <li>
                        <a class="@if($menu == 'Trash') active @endif" href="{!! URL::to('user/event-trash') !!}"><i class="fa fa-fw fa-trash-o"></i>Trash</a>
                    </li>
                    <li>
                        <a class="@if($menu == 'Setting') active @endif" href="#"><i class="fa fa-fw fa-wrench"></i> Setting<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!! URL::to('user/update-info') !!}">Update Info</a>
                            </li>
                            <li>
                                <a href="{!! URL::to('user/password-change') !!}">Change Password</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a class="@if($menu == 'Report') active @endif" href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Report<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!! URL::to('user/table-report') !!}">Table Report</a>
                            </li>
                            <li>
                                <a href="{!! URL::to('user/calender-report') !!}">Calendar Report</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

    <div id="page-wrapper">
        @yield('content')
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Bootstrap Core JavaScript -->
{!! HTML::script('js/bootstrap.min.js') !!}
{!! HTML::script('js/jquery-ui.js') !!}
{!! HTML::script('js/timepicker.js') !!}

<!-- Metis Menu Plugin JavaScript -->
{!! HTML::script('js/metisMenu.min.js') !!}

{!! HTML::script('js/sb-admin-2.js') !!}
</body>

</html>