<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Fonts --}}
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        {{-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> --}}

        {{-- CSS --}}
        <link rel="stylesheet" href="{{ asset('css/sb_main.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        {{-- JS --}}
    </head>
    <body>
        <div id="app"></div>

        
        <script src="{{ mix('js/app.js') }}"></script>
        {{-- <script src="{{ asset('js/sb_main.min.js') }}"></script> --}}
    </body>
</html>
