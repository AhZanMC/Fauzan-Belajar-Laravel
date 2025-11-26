<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko Fauzan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">
        
        {{-- Navbar Login/Register di pojok kanan atas --}}
        @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        {{-- Konten Jumbotron --}}
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-12 text-center">
                <h1 class="text-5xl font-bold text-gray-800 mb-4">Selamat Datang di Toko Fauzan!</h1>
                <p class="text-lg text-gray-600 mb-8">
                    Sistem Inventaris Sederhana dengan Laravel 10, Tailwind CSS, dan Cinta.
                </p>
                
                <div class="flex justify-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
                            Ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
                            Login Sekarang
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg shadow-md hover:bg-gray-300 transition duration-300">
                            Daftar Akun
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</body>
</html>