<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>SiKecilSehat - {{ $title }}</title>

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('dashmin/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashmin/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('dashmin/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashmin/modules/weather-icon/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashmin/modules/weather-icon/css/weather-icons-wind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashmin/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('dashmin/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('dashmin/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashmin/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashmin/modules/prism/prism.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('dashmin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dashmin/css/components.css') }}">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">

            @include('dashboard.layouts.header')

            @include('dashboard.layouts.sidebar')

            @yield('container')

            @include('dashboard.layouts.footer')
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('dashmin/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('dashmin/modules/popper.js') }}"></script>
    <script src="{{ asset('dashmin/modules/tooltip.js') }}"></script>
    <script src="{{ asset('dashmin/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dashmin/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('dashmin/modules/moment.min.js') }}"></script>
    <script src="{{ asset('dashmin/js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('dashmin/modules/simple-weather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('dashmin/modules/chart.min.js') }}"></script>
    <script src="{{ asset('dashmin/modules/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('dashmin/modules/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('dashmin/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('dashmin/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <script src="{{ asset('dashmin/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('dashmin/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashmin/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('dashmin/modules/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('dashmin/modules/prism/prism.js') }}"></script>


    <!-- Page Specific JS File -->
    <script src="{{ asset('dashmin/js/page/index-0.js') }}"></script>
    <script src="{{ asset('dashmin/js/page/modules-datatables.js') }}"></script>
    <script src="{{ asset('dashmin/js/page/bootstrap-modal.js') }}"></script>


    <!-- Template JS File -->
    <script src="{{ asset('dashmin/js/scripts.js') }}"></script>
    <script src="{{ asset('dashmin/js/custom.js') }}"></script>
</body>

</html>
