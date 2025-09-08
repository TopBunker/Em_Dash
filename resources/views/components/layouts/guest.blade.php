<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'em-dash' ) }}</title>

        <!-- Styles and Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-poppins antialiased max-h-dvh">
        <!-- Background Pixi Canvas-->
        <div id="canvas" class="fixed inset-0 -z-10"></div>

        <!--Page Wrapper-->
        <div class="@container relative inset-0 h-dvh bg-transparent">
            {{$slot}}
        </div>     
    </body>
</html>