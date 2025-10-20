@extends('layouts.app')

@section('title', 'Edit Barang: ' . $item->item_name)

@section('content')
    <h1>Edit Barang: {{ $item->item_name }}</h1>

    <div class="card">
        <div class="card-body">
            {{-- Form akan mengirim data ke route 'items.update' dengan method POST, tapi kita palsukan sebagai PUT --}}
            <form action="{{ route('items.update', $item->id_item) }}" method="POST">
                @csrf
                @method('PUT') {{-- Ini adalah method spoofing untuk request PUT/PATCH --}}

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="item_code" class="form-label">Kode Barang</label>
                        {{-- 'old()' akan memprioritaskan data lama dari sesi (jika validasi gagal), jika tidak ada, tampilkan data dari database --}}
                        <input type="text" class="form-control @error('item_code') is-invalid @enderror" id="item_code" name="item_code" value="{{ old('item_code', $item->item_code) }}" required>
                        @error('item_code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="item_name" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control @error('item_name') is-invalid @enderror" id="item_name" name="item_name" value="{{ old('item_name', $item->item_name) }}" required>
                        @error('item_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="id_category" class="form-label">Kategori</label>
                    <select class="form-select @error('id_category') is-invalid @enderror" id="id_category" name="id_category">
                        <option selected disabled value="">Pilih Kategori...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id_category }}" {{ old('id_category', $item->id_category) == $category->id_category ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_category')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $item->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $item->stock) }}" required>
                        @error('stock')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Harga</label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $item->price) }}" required>
                        @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('items.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Barang</button>
                </div>
            </form>
        </div>
    </div>
@endsection
