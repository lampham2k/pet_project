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
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="{{ asset('css/material-dashboard.css') }}" rel="stylesheet">
        <link href="{{ asset('css/demo.css') }}" rel="stylesheet">
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        @stack('css')
     </head>
   <body>
      <div class="wrapper">
         @include('layout.sidebar')
         <div class="main-panel">
            @include('layout.topbar')
            <div class="content">
               <div class="container-fluid">
               @yield('content')  
               </div>
            </div>
         </div>
      </div>
      <script src="{{ asset('js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
      {{-- <script src="{{ asset('jquery.bootstrap-wizard.js') }}" type="text/javascript"></script> --}}
      <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
      <script src="{{ asset('js/material.min.js') }}" type="text/javascript"></script>
      <script src="{{ asset('js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
      <script src="{{ asset('js/core.js') }}"></script>
      <script src="{{ asset('js/arrive.min.js') }}" type="text/javascript"></script>
      <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
      <script src="{{ asset('js/moment.min.js') }}"></script>
      <script src="{{ asset('js/chartist.min.js') }}"></script>
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
      <script src="{{ asset('js/helper.js') }}"></script>
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script type="text/javascript">
         $(document).ready(function() {
             demo.initDashboardPageCharts();
             demo.initVectorMap();
         });
      </script>
      @stack('js')
   </body>
</html>