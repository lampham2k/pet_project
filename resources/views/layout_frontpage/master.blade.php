<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <title>Sections - Material Kit PRO by Creative Tim</title>
      <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
      <!-- CSS Files -->
      <link href="{{ asset('css_homepage/bootstrap.min.css') }}" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
      <link href="{{ asset('css_homepage/material-kit.css') }}"  rel="stylesheet">
      <!--     Fonts and icons     -->
      <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
      <!--     CSS custom     -->
      @stack('css')
   </head>
   <body class="ecommerce-page">
      @include('layout_frontpage.navbar')
      @yield('content')
      @include('layout_frontpage.footer')
      <script src="{{ asset('js_homepage/jquery.min.js') }}" type="text/javascript"></script>
      <script src="{{ asset('js_homepage/bootstrap.min.js') }}" type="text/javascript"></script>
      <script src="{{ asset('js_homepage/material.min.js') }}"></script>
      <script src="{{ asset('js_homepage/moment.min.js') }}"></script>
      <script src="{{ asset('js_homepage/nouislider.min.js') }}" type="text/javascript"></script>
      <script src="{{ asset('js_homepage/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
      <script src="{{ asset('js_homepage/bootstrap-selectpicker.js') }}" type="text/javascript"></script>
      <script src="{{ asset('js_homepage/bootstrap-tagsinput.js') }}"></script>
      <script src="{{ asset('js_homepage/jasny-bootstrap.min.js') }}"></script>
      <script src="{{ asset('js_homepage/notify.min.js') }}"></script>
      <script src="{{ asset('js/helper.js') }}"></script>
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
      @stack('js')
   </body>
</html>
