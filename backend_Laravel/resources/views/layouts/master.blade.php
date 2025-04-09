<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
        <link href='http://fonts.googleapis.com/css?family=Arizonia' rel='stylesheet' type='text/css'>
        <title>lumé</title>
        <!-- CSS and Scripts -->
        @stack('styles')
    </head>
    <body>
    
        {{-- uses laravels authentification to check if they are logged in, if they are: display the navbar --}}
        {{-- @if(Auth::check()) 
            @include('layouts.header')
        @endif --}}
    
        <div>
            @yield('content')
        </div>
    
        {{-- @include('layouts.footer') --}}

    </body>
</html>
