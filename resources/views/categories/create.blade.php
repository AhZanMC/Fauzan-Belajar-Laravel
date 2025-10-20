@extends('layouts.app')

@section('title', 'Tambah Kategori Baru')

@section('content')
    <h1>Tambah Kategori Baru</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            {{-- Form akan mengirim data ke route 'categories.store' dengan method POST --}}
            <form action="{{ route('categories.store') }}" method="POST">
                {{-- @csrf adalah token keamanan yang wajib ada di setiap form Laravel --}}
                @csrf

                <div class="mb-3">
                    <label for="category_name" class="form-label">Nama Kategori</label>
                    <input type="text" 
                           class="form-control @error('category_name') is-invalid @enderror" 
                           id="category_name" 
                           name="category_name" 
                           value="{{ old('category_name') }}" 
                           required 
                           autofocus>
                    
                    {{-- Blok ini akan tampil jika validasi untuk 'category_name' gagal --}}
                    @error('category_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
@endsection
