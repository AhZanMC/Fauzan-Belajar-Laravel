<!DOCTYPE html>
<html>
<head>
    <title>App Name - @yield('title')</title>
    {{-- Include CSS & JS Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>