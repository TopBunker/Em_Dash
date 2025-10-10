<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Default Meta Description --}}
        <meta name="description" content="@yield('meta_description', 'Em-Dash specialises in web development and content strategy. Collaborate with us to find the right solutions for your project needs.')">

        {{-- Social Share --}}
        <meta property="og:title" content="@yield('meta_title', 'Em-Dash')">
        <meta property="og:description" content="@yield('meta_description', 'Em-Dash specialises in web development and content strategy. Collaborate with us to find the right solutions for your project needs.')">
        <meta property="og:image" content="@yield('meta_image', asset('images/system/logo.png'))">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="twitter:card" content="summary_large_image">

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon_io/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon_io/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon_io/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('favicon_io/site.webmanifest') }}">
        <link rel="shortcut icon" href="{{ asset('favicon_io/favicon.ico') }}">

        <title>Welcome - {{ config('app.name', 'Em-Dash' ) }}</title>

        <!-- Styles and Scripts -->
        @vite(['resources/js/app.js'])
    </head>
    <body class="font-poppins antialiased max-h-dvh max-w-dvw">
        <!-- Background Pixi Canvas-->
        <div id="canvas" class="fixed inset-0 -z-10 h-dvh w-dvw"></div>

        <!--Page Wrapper-->
        <div class="@container relative inset-0 max-h-dvh max-w-dvw bg-transparent">
            @yield('content', $slot  ?? '')
        </div>   
        
        @stack('scripts')
    </body>
</html>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('update-page-title', data => {
            let baseTitle = '{{ config('app.name', 'Em-Dash' ) }}';
            if(data[0].title && data[0].title.length > 0){
                document.title = `${data[0].title} - ${baseTitle}`;
            }else{
                document.title = `Welcome - ${baseTitle}`;
            }
        });
    });
</script>