<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://use.fontawesome.com/releases/v5.5.0/js/all.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/dashboard.css">
    <script type="text/javascript"
            src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
    </script>
    @yield('css')
    <title>Dashboard-@yield('title')</title>
</head>
<body onload="submit_button()">
@include('inc.message_popup')
<!-- navbar -->
@include('inc.dashboardNavbar')
<!-- end of navbar -->

@yield('content')

@yield('js')
<script src="{{asset('js/app.js')}}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
</body>
</html>






