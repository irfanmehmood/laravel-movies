<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MovieFlix -  @yield('title', 'Movies Database')</title>
    <meta property="og:title" content="@yield('title', 'Movies Database')" />
    <meta property="og:description" content="@yield('description', 'Movies Database to find upcoming and latest movies trailers and information')" />
    <meta property="og:type"  content="video.movies" />
    <meta property="og:url"   content="{{url()->current()}}" />
    <meta property="og:image" content="@yield('image', '')" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <livewire:styles>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body class="font-sans bg-gray-900 text-white">
    @include('layouts.partials.nav')
    @yield('content')
    <footer class="border border-t border-gray-800">
        <div class="container mx-auto text-sm px-4 py-6">
            <div class="flex mb-4 container">
                <div class="w-1/2">Developed by <span class="text-blue-300">Irfan Mehmood</span></div>
                <div class="w-1/2 text-right ">Powered by Laravel 8 & <a href="https://www.themoviedb.org/documentation/api" class="underline hover:text-gray-300">TMDb API</a></div>
            </div>
        </div>
        <!-- Two columns -->
        
    </footer>
    <livewire:scripts>
    @yield('scripts')
</body>
</html>