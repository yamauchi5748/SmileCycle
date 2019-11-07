<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <!-- CSRF Token -->
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >
    <meta
        name="api-token"
        content="{{ $member->api_token }}"
    >

    <title>{{ config('app.name', 'SmileCycle') }}</title>

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'apiToken' => \Auth::user()->api_token ?? null
        ]) !!};
    </script>
    <script
        src="{{ mix('js/app.js') }}"
        defer
    ></script>

    <!-- Styles -->
    <link
        href="{{ asset('css/app.css') }}"
        rel="stylesheet"
    >
</head>

<body>
    <div id="app">
        <home-component :author ="{{$member}} "></home-component>
    </div>
</body>

</html>