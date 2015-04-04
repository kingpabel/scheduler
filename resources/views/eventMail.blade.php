<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kingpabel Scheduler List</title>

    {!! HTML::script('js/jquery-2.0.3.min.js') !!}
    <!-- Bootstrap Core CSS -->
    {!! HTML::style('css/bootstrap.min.css') !!}

    <!-- Custom Fonts -->
    {!! HTML::style('font-awesome/css/font-awesome.min.css') !!}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-60038966-1', 'auto');
        ga('send', 'pageview');

    </script>
</head>

<body>

<div class="row" style="margin-top: 20px">
    <div class="col-md-6 col-md-offset-3">
        <h1 style="margin-left: 20%"><?php echo date('Y-m-d')?> Event List</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
            </thead>
            <tbody>
            @foreach($mailProfile->Schedule as $key=>$scheduleList)
            <tr>
                <th scope="row">{!! $key+1 !!}</th>
                <td>{!! $scheduleList->title !!}</td>
                <td>{!! date('Y-m-d H:i', strtotime($scheduleList->start_time)) !!}</td>
                <td>{!! date('Y-m-d H:i', strtotime($scheduleList->end_time)) !!}</td>
            </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap Core JavaScript -->
{!! HTML::script('js/bootstrap.min.js') !!}

</body>

</html>