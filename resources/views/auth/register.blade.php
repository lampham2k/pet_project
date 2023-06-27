<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{{ config('app.name') }}</title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
        <meta name="viewport" content="width=device-width">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/material-dashboard.css') }}" rel="stylesheet">
        <link href="{{ asset('css/demo.css') }}" rel="stylesheet">
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
     </head>
     <body class="off-canvas-sidebar">
        <nav class="navbar navbar-primary navbar-transparent navbar-absolute">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href=" ../dashboard.html ">lamPhamShop</a>
                </div>
            </div>
        </nav>
        <div class="wrapper wrapper-full-page">
            <div class="full-page login-page" filter-color="black" data-image="{{ asset('image/login.jpeg') }}">
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                                <form method="POST" action="{{ route('registering') }}">
                                    @csrf
                                    <div class="card card-login card-hidden">
                                        <div class="card-header text-center" data-background-color="rose">
                                            <h4 class="card-title">Register</h4>
                                        </div>
                                        <div class="card-content">
                                            @auth()
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">face</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Full Name</label>
                                                    <input type="text" class="form-control" name="name" value="{{ user()->name }}">
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">email</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Email address</label>
                                                    <input type="email" class="form-control" name="email" value="{{ user()->email }}">
                                                </div>
                                            </div>
                                            @endauth

                                            @guest()
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">face</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label" for="fullName">Full Name</label>
                                                    <input type="text" class="form-control" name="name" id="fullName">
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">email</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label" for="email">Email address</label>
                                                    <input type="email" class="form-control" name="email" id="email">
                                                </div>
                                            </div>
                                            @endguest
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">lock_outline</i>
                                                </span>
                                                <div class="form-group label-floating">
                                                    <label class="control-label" for="password">Password</label>
                                                    <input type="password" class="form-control" name="password" id="password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="footer text-center">
                                            <button type="submit" class="btn btn-rose btn-simple btn-wd btn-lg">Let's go</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer">
                    <div class="container">
                        <p class="copyright pull-right">
                            &copy;
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                            <a href="http://www.creative-tim.com"> Creative Tim </a>, made with love for a better web
                        </p>
                    </div>
                </footer>
            </div>
        </div>
    </body>
   <script src="{{ asset('js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
   <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
   <script src="{{ asset('js/material.min.js') }}" type="text/javascript"></script>
   <script src="{{ asset('js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
   <script src="{{ asset('js/core.js') }}"></script>
   <script src="{{ asset('js/arrive.min.js') }}" type="text/javascript"></script>
   <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
   <script src="{{ asset('js/moment.min.js') }}"></script>
   <script src="{{ asset('js/chartist.min.js') }}"></script>
   <script src="{{ asset('jquery.bootstrap-wizard.js') }}"></script>
   <script src="{{ asset('js/bootstrap-notify.js') }}"></script>
   <script src="{{ asset('js/bootstrap-datetimepicker.js') }}"></script>
   <script src="{{ asset('js/jquery-jvectormap.js') }}"></script>
   <script src="{{ asset('js/nouislider.min.js') }}"></script>
   <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
   <script src="{{ asset('js/jquery.select-bootstrap.js') }}"></script>
   <script src="{{ asset('js/jquery.datatables.js') }}"></script>
   <script src="{{ asset('js/sweetalert2.js') }}"></script>
   <script src="{{ asset('js/jasny-bootstrap.min.js') }}"></script>
   <script src="{{ asset('js/fullcalendar.min.js') }}"></script>
   <script src="{{ asset('js/jquery.tagsinput.js') }}"></script>
   <script src="{{ asset('js/material-dashboard.js') }}"></script>
   <script src="{{ asset('js/demo.js') }}"></script>
   <script type="text/javascript">
    $().ready(function() {
        demo.checkFullPageBackgroundImage();

        setTimeout(function() {
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>
</html>