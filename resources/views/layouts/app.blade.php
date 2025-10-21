<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Menggunakan judul dinamis, jika tidak ada, defaultnya 'Fauzan Belajar Laravel' --}}
    <title>@yield('title', 'Fauzan Belajar Laravel')</title>

    {{-- Ini adalah cara Blade untuk memanggil file CSS dan JS yang sudah di-compile oleh Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{-- Navbar sederhana dari Bootstrap --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Inventaris App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('items.index') }}">Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}">Kategori</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        {{-- Di sinilah konten dari halaman lain akan disisipkan --}}
        @yield('content')
    </main>

    <footer class="text-center mt-5 text-muted">
        <p>&copy; 2025 Fauzan Belajar Laravel</p>
    </footer>
</body>
</html>
