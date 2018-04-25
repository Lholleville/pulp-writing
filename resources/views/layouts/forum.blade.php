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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/countrySelect.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome-4.7.0/css/font-awesome.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/JQuery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/angular.js') }}"></script>
    <script src="{{ asset('js/angularPerso.js') }}"></script>
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/countrySelect.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/load-image.all.min.js') }}"></script>
    <script src="{{ asset('js/loadImage.js') }}"></script>
    <script src="{{ asset('js/jscolor.min.js') }}"></script>
    <script src="{{ url('/js/ckeditor/ckeditor.js') }}"></script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if (Auth::user())
                        &nbsp;<li><a href="{{ route('atelier') }}">ECRIRE</a></li>
                    @endif
                    @if (Auth::user())
                        <li><a href="{{ action('ForumsController@index') }}">FORUMS</a></li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/profil/'.Auth::user()->name) }}">Profil</a>
                                </li>
                                @if(Auth::user()->roles->name == "admin")
                                    <li>
                                        <a href="{{ url('/admin') }}">Admin</a>
                                    </li>
                                @endif
                                @if(Auth::user()->roles->name == "modo" || Auth::user()->isModo())
                                    <li>
                                        <a href="{{ url('/moderation') }}">Modération</a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>

                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        @include('flash')
        <div class="row">
            <div class="col-sm-4">
                <h1>{{ $forum->name }}</h1>
            </div>
            <div class="col-sm-8 forum-description">
                <p>{{ $forum->description }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <h2>Modérateurs du forum</h2>
                <ul class="list-group">
                    @foreach($forum->users as $modo)
                        <li class="list-group-item">
                            <p>
                                {{$modo->name}} <img src="{{ url($modo->avatar) }}" alt="Avatar du modérateur {{ $modo->name }}" class="img-responsive" width="50" height="50">
                                <br><a href="" class="btn btn-default"><i class="fa fa-envelope"></i> Contacter</a>
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @yield('secondary')

    </div>
</div>
<script src="{{ asset('js/js-custom.js') }}"></script>

<script src="{{ url('/js/laravel.js') }}"></script>

</body>
</html>
