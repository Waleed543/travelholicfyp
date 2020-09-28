<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TravelHlolic @yield('title')</title>
    <!-- Styles -->
    <!-- Material Design Bootstrap -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript"
            src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
    </script>
    @yield('css-files')
</head>

<body>

    <!-- Navigation -->
    @include('inc.header')
    <!-- End Navigation -->

    @yield('content')

    @include('inc.footer')
<!--- End Contact Section -->


<!--- Script Source Files -->
    <script src="{{asset('js/app.js')}}" type="text/javascript"></script>

    <script src="https://kit.fontawesome.com/15ce08dfb5.js" crossorigin="anonymous"></script>
    <!-- MDB core JavaScript -->
<!--- End of Script Source Files -->

</body>
</html>
