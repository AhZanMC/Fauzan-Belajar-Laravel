@extends('layouts.app')

@section('title', 'Detail Kategori: ' . $category->category_name)

@section('content')
    <h1>Kategori: {{ $category->category_name }}</h1>
    <p>Berikut adalah semua barang dalam kategori ini.</p>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary mb-3">Kembali ke Daftar Kategori</a>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kode Barang</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($category->items as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->item_code }}</td>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Belum ada barang di dalam kategori ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
