@extends('layouts.app')

@section('title', 'Detail Barang: ' . $item->item_name)

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Detail Barang</h1>
            <a href="{{ route('items.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-150">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Kolom Informasi Utama -->
                    <div class="md:col-span-2">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $item->item_name }}</h2>
                        <p class="text-sm text-gray-500 mb-4">Kode: {{ $item->item_code }}</p>
                        
                        <div class="border-t border-gray-200 pt-4">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $item->category->category_name ?? 'Tanpa Kategori' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $item->description ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Ditambahkan Pada</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $item->created_at->format('d F Y, H:i') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Terakhir Diupdate</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $item->updated_at->format('d F Y, H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Kolom Informasi Stok & Harga -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Info Stok & Harga</h3>
                        
                        <div class="mb-4">
                            <span class="block text-sm font-medium text-gray-500">Stok Tersedia</span>
                            <span class="text-3xl font-bold text-gray-800">{{ $item->stock }}</span>
                            <span class="text-sm text-gray-500 ml-1">unit</span>
                        </div>
                        
                        <div class="mb-6">
                            <span class="block text-sm font-medium text-gray-500">Harga Satuan</span>
                            <span class="text-2xl font-bold text-indigo-600">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex flex-col space-y-2">
                            <a href="{{ route('items.edit', $item->id_item) }}" class="w-full text-center px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition duration-150">
                                Edit Barang Ini
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection