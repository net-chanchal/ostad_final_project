<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

    <!-- Title -->
    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('storage/uploads/' .  CoreHelper::getSetting('SETTING_SITE_FAVICON')) }}"
          type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('app/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/lightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/hover-min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/responsive.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<!--Preloader Start-->
<div id="preloader">
    <div id="status" style="background-image: url('{{ asset('app/img/preloader/3.gif') }}')"></div>
</div>
<!--Preloader End-->

@yield('content')

@include('app.layouts.footer')

<!--Scroll-Top-->
<div class="scroll-top">
    <i class="fa fa-angle-up"></i>
</div>
<!--Scroll-Top-->

<!--Js-->
<script src="{{ asset('app/js/jquery-2.2.4.min.js') }}"></script>
<script src="{{ asset('app/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('app/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('app/js/lightbox.min.js') }}"></script>
<script src="{{ asset('app/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('app/js/jquery.meanmenu.js') }}"></script>
<script src="{{ asset('app/js/jquery.filterizr.min.js') }}"></script>
<script src="{{ asset('app/js/jquery.collapse.js') }}"></script>
<script src="{{ asset('app/js/waypoints.min.js') }}"></script>
<script src="{{ asset('app/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('app/js/viewportchecker.js') }}"></script>
<script src="{{ asset('app/js/custom.js') }}"></script>

@stack('scripts')
</body>
</html>