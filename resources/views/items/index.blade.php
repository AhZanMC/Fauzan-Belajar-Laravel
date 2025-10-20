{{-- Memberitahu Blade untuk menggunakan layout dari 'layouts.app' --}}
@extends('layouts.app')

{{-- Mengisi bagian 'title' di layout induk --}}
@section('title', 'Daftar Barang')

{{-- Mengisi bagian 'content' di layout induk --}}
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Daftar Barang</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Tambah Kategori Baru</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kode</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse adalah perulangan yang punya kondisi jika data kosong --}}
                    @forelse ($items as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->item_code }}</td>
                            <td>{{ $item->item_name }}</td>
                            {{-- Cek jika kategori ada, tampilkan namanya. Jika tidak, tampilkan '-' --}}
                            <td>{{ $item->category->category_name ?? '-' }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">Detail</a>
                                <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                        </tr>
                    @empty
                        {{-- Bagian ini akan tampil jika $items kosong --}}
                        <tr>
                            <td colspan="7" class="text-center">
                                Belum ada data barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
