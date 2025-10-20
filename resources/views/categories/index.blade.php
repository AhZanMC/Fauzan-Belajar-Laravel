@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
    {{-- Bagian Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Daftar Kategori</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Tambah Kategori Baru</a>
    </div>

    {{-- Container untuk Tabel --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                {{-- Kepala Tabel --}}
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="width: 5%;">#</th>
                        <th scope="col">Nama Kategori</th>
                        <th scope="col" style="width: 20%;">Jumlah Barang</th>
                        <th scope="col" style="width: 25%;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                {{-- Isi Tabel --}}
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            {{-- Nomor urut --}}
                            <th scope="row">{{ $loop->iteration }}</th>
                            
                            {{-- Nama Kategori --}}
                            <td>{{ $category->category_name }}</td>
                            
                            {{-- Jumlah item (menggunakan properti items_count dari controller) --}}
                            <td>{{ $category->items_count }} Barang</td>
                            
                            {{-- Tombol Aksi (Detail, Edit, Hapus) --}}
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Aksi Kategori">
                                    {{-- Tombol Detail --}}
                                    <a href="{{ route('categories.show', $category->id_category) }}" class="btn btn-sm btn-info">Detail</a>
                                    
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('categories.edit', $category->id_category) }}" class="btn btn-sm btn-warning">Edit</a>
                                    
                                    {{-- Tombol Hapus (dengan form untuk keamanan) --}}
                                    <form action="{{ route('categories.destroy', $category->id_category) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Tindakan ini tidak bisa dibatalkan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Pesan jika tidak ada data sama sekali --}}
                        <tr>
                            <td colspan="4" class="text-center">
                                <div class="alert alert-warning mb-0">
                                    Belum ada data kategori. <a href="{{ route('categories.create') }}" class="alert-link">Tambahkan data baru sekarang!</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

