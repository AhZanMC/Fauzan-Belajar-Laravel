@extends('layouts.app')

@section('title', 'Selamat Datang di Toko Fauzan')

@section('content')
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Selamat Datang!</h1>
            <p class="col-md-8 fs-4">Ini adalah halaman utama aplikasi inventaris sederhana kita. Di bawah ini adalah barang-barang yang tersedia.</p>
        </div>
    </div>

    <h2>Daftar Barang</h2>
    <div class="row">
        @forelse ($items as $item)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->item_name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $item->item_code }}</h6>
                        <p class="card-text">
                            <strong>Harga:</strong> Rp {{ number_format($item->price, 0, ',', '.') }}<br>
                            <strong>Stok:</strong> {{ $item->stock }} unit
                        </p>
                        <a href="{{ route('items.show', $item->id_item) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </div>
                    @if ($item->category)
                        <div class="card-footer text-muted">
                            Kategori: {{ $item->category->category_name }}
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col">
                <div class="alert alert-warning">
                    Belum ada barang yang dijual.
                </div>
            </div>
        @endforelse
    </div>
@endsection
