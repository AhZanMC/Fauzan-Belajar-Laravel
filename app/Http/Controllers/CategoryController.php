<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar semua kategori.
     */
    public function index()
    {
        $categories = Category::withCount('items')->latest()->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Menampilkan form untuk membuat kategori baru.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Menyimpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:100|unique:tb_categories,category_name',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')
                         ->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu kategori beserta barang-barangnya.
     */
    public function show(Category $category)
    {
        // 'load('items')' digunakan untuk memuat relasi items
        // Ini lebih efisien jika kamu butuh data item lengkap di view
        $category->load('items'); 
        return view('categories.show', compact('category'));
    }

    /**
     * Menampilkan form untuk mengedit kategori.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Memperbarui data kategori di database.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => ['required', 'string', 'max:100', Rule::unique('tb_categories')->ignore($category->id_category, 'id_category')],
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus kategori dari database.
     */
    public function destroy(Category $category)
    {
        // Pengecekan keamanan: jangan hapus kategori jika masih ada barang di dalamnya.
        if ($category->items()->count() > 0) {
            return redirect()->route('categories.index')
                             ->with('error', 'Gagal menghapus! Kategori ini masih memiliki ' . $category->items()->count() . ' barang terkait.');
        }

        $category->delete();

        return redirect()->route('categories.index')
                         ->with('success', 'Kategori berhasil dihapus.');
    }
}