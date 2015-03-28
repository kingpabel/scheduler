<!DOCTYPE html>
<html lang="en">
{!!
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
!!}
<head>
    <title>Kingpabel Scheduler Login</title>

    {!! HTML::script('js/jquery-2.0.3.min.js') !!}
    <!-- Bootstrap Core CSS -->
    {!! HTML::style('css/bootstrap.min.css') !!}

    <!-- Custom CSS -->
    {!! HTML::style('css/sb-admin-2.css') !!}

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

<div class="container">


    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                @if(Session::get('error'))
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-info-circle"></i> {!! Session::get('error') !!}
                            </div>
                @endif
                <div class="panel-heading">
                    <h3 class="panel-title">Kingpabel Scheduler Login</h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(array('accept-charset' => 'utf-8', 'role' => 'form', 'url' => 'account/login')) !!}
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Password" name="password" type="password" required>
                        </div>
                        <div class="form-group">
                            <a style="text-decoration: none" href="{!! URL::to('account/create') !!}">Create an Account</a>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-lg btn-success btn-block" value="Login">
                        </div>
                        <!-- Change this to a button or input when using this as a form -->

                    </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Core JavaScript -->
{!! HTML::script('js/bootstrap.min.js') !!}

<!-- Custom Theme JavaScript -->
{!! HTML::script('js/sb-admin-2.js') !!}

</body>

</html>