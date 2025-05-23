<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="https://tdoctor.net/images/shop/favicon.jpg">
    <link rel="icon" type="image/png" href="https://tdoctor.net/images/shop/favicon.jpg">
    <link rel="icon" href="https://tdoctor.net/images/shop/favicon.jpg">
    <link rel="shortcut icon" href="https://tdoctor.net/images/shop/favicon.jpg" type="image/x-icon">
    <title>@yield("title")</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{asset("css/nucleo-icons.css")}}" rel="stylesheet" />
    <link href="{{asset("css/nucleo-svg.css")}}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link id="pagestyle" href="{{asset("css/argon-dashboard.css?v=2.0.4")}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @stack("css")
</head>

<body class="g-sidenav-show bg-gray-100">
<div class="min-height-300 bg-primary position-absolute w-100"></div>
{{--@include("layouts.sidebar")--}}
<main class="main-content position-relative border-radius-lg">
    @yield("breadcrumbs")
    <div class="container-fluid py-4 mt-2">
        @yield("main")
    </div>
</main>

<script src="{{asset("js/core/popper.min.js")}}"></script>
<script src="{{asset("js/core/bootstrap.min.js")}}"></script>
<script src="{{asset("js/plugins/perfect-scrollbar.min.js")}}"></script>
<script src="{{asset("js/plugins/smooth-scrollbar.min.js")}}"></script>
<script src="{{asset("js/plugins/chartjs.min.js")}}"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="{{asset("js/argon-dashboard.min.js?v=2.0.4")}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@stack('js')
</body>
</html>
