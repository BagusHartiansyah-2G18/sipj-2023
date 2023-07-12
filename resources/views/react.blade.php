<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel React</title>
    <link rel="stylesheet" href="{{url('css/output.css')}}" >
    <link rel="stylesheet" href="{{url('MaterialDesignIcons6/css/materialdesignicons.min.css')}}";>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
</head>
<body>

    @if (Route::has('login'))
            @auth
                <div id="app"></div>
                <script src="{{ asset('js/manifest.js') }}"></script>
                <script src="{{ asset('js/vendor.js') }}"></script>
                <script src="{{ asset('js/app.js') }}"></script>

            @else
                <script>window.location = "{{ url('login') }}";</script>
            @endauth
        </div>
    @endif
</body>
</html>

