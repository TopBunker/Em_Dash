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
        <div id="profile" x-data="{currentPage: 'resume', reveal: true, close(){this.reveal = false}, open(){this.reveal = true}}" @open="open()" @close="close()" class="@container relative inset-0 h-dvh bg-transparent px-2">
            <!--Header-->
            <header class="fixed z-10 top-0 left-0 right-0 bg-white/30 backdrop-blur-md shadow-md border-b border-accent-dark">
                @yield('header')
            </header>

            {{$slot}}

            <!--Footer-->
            <footer class="fixed z-10 bottom-0 left-0 right-0">
                <livewire:layouts.footer />
            </footer>
        </div>     
    </body>
</html>