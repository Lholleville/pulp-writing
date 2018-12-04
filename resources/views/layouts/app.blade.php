<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{!! csrf_token() !!}">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/countrySelect.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/rocketScroll.css') }}" rel="stylesheet">
    <link href="{{ asset('css/prety-checkbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css-theme-grey.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    <!-- AUTO COMPLETE STYLE CSS-->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.8/angular-material.min.css">
    <!-- Scripts -->
    <script src="{{ asset('js/JQuery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <script src="{{ asset('js/angularPerso.js') }}"></script>
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/countrySelect.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/load-image.all.min.js') }}"></script>
    <script src="{{ asset('js/loadImage.js') }}"></script>
    <script src="{{ asset('js/jscolor.min.js') }}"></script>
    <script src="{{ url('/js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ url('/js/rocketHelpers.js') }}"></script>
    <script src="{{ url('/js/rocketScroll.js') }}"></script>
    <script src="{{ url('/js/back.js') }}"></script>
    <script src="{{ url('/js/profilemenu.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.7/angular-animate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.7/angular-aria.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.7/angular-messages.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.10/angular-sanitize.js"></script>

    <!-- AngularJS Material Javascript now available via Google CDN; version 1.1.4 used here -->
    <script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.9/angular-material.min.js"></script>
</head>
<body>
<div id="app">
@include('navbar')
@include('flash')
@yield('content')

</div>

<script src="{{ asset('js/js-custom.js') }}"></script>
<script src="{{ url('/js/laravel.js') }}"></script>

</body>
</html>
