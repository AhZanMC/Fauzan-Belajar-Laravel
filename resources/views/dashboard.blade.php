@extends('layouts.app')

@section('title', 'Dashboard Toko Fauzan')

@section('content')
    <!-- Hero Section -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8 border-l-4 border-indigo-500">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
                        Halo, <span class="text-indigo-600">{{ Auth::user()->name }}!</span> 👋
                    </h1>
                    <p class="text-lg text-gray-600 mt-2">
                        Selamat datang kembali di panel admin.
                    </p>
                </div>
                {{-- Statistik Ringkas --}}
                <div class="flex space-x-4">
                    <div class="text-center px-4 py-2 bg-blue-50 rounded-lg">
                        <span class="block text-2xl font-bold text-blue-600">{{ $items->count() }}</span>
                        <span class="text-xs text-blue-500 font-semibold uppercase">Total Barang</span>
                    </div>
                    <div class="text-center px-4 py-2 bg-green-50 rounded-lg">
                        <span class="block text-2xl font-bold text-green-600">{{ $categories->count() }}</span>
                        <span class="text-xs text-green-500 font-semibold uppercase">Kategori</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Katalog Barang -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Katalog Barang Terbaru</h2>
        <a href="{{ route('items.create') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
            + Tambah Barang Baru
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($items as $item)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col">
                <!-- Gambar Placeholder -->
                <div class="h-48 bg-gray-200 flex items-center justify-center relative group">
                    <svg class="w-12 h-12 text-gray-400 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    
                    <!-- Badge Kategori -->
                    <span class="absolute top-2 right-2 bg-white bg-opacity-90 text-xs font-bold px-2 py-1 rounded-md text-gray-600 shadow-sm">
                        {{ $item->category->category_name ?? 'Umum' }}
                    </span>
                </div>
                
                <div class="p-4 flex-1 flex flex-col">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1 truncate" title="{{ $item->item_name }}">
                        {{ $item->item_name }}
                    </h3>
                    
                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                        <div>
                            <p class="text-xs text-gray-500">Harga</p>
                            <p class="text-lg font-bold text-indigo-600">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Stok</p>
                            <p class="text-sm font-medium {{ $item->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $item->stock }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <a href="{{ route('items.show', $item->id_item) }}" class="block w-full text-center px-3 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 transition">
                            Detail
                        </a>
                        <a href="{{ route('items.edit', $item->id_item) }}" class="block w-full text-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <!-- Heroicon name: solid/exclamation -->
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Belum ada barang. <a href="{{ route('items.create') }}" class="font-medium underline hover:text-yellow-600">Tambah barang baru</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
@endsection