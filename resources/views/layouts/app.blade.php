    @include('navbar')
    <br>
    <div class="container">
        @include('flash')
        @yield('content')
    </div>
</div>

<script src="{{ asset('js/js-custom.js') }}"></script>
<script src="{{ url('/js/laravel.js') }}"></script>

</body>
</html>
