<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    /**
     * Menampilkan halaman utama dengan daftar barang.
     */
    public function home()
    {
        $items = Item::with('category')->latest()->get();
        return view('home', compact('items'));
    }

    /**
     * Menampilkan daftar semua barang (halaman kelola).
     */
    public function index()
    {
        $items = Item::with('category')->latest()->get();
        return view('items.index', compact('items'));
    }

    /**
     * Menampilkan form untuk membuat barang baru.
     */
    public function create()
    {
        $categories = Category::orderBy('category_name')->get();
        return view('items.create', compact('categories'));
    }

    /**
     * Menyimpan barang baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'item_code' => 'required|string|max:50|unique:tb_items,item_code',
            'item_name' => 'required|string|max:100',
            'id_category' => 'nullable|exists:tb_categories,id_category',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // Simpan data baru
        Item::create($request->all());

        return redirect()->route('items.index')
                         ->with('success', 'Barang baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu barang.
     */
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    /**
     * Menampilkan form untuk mengedit barang.
     */
    public function edit(Item $item)
    {
        $categories = Category::orderBy('category_name')->get();
        return view('items.edit', compact('item', 'categories'));
    }

    /**
     * Memperbarui data barang di database.
     */
    public function update(Request $request, Item $item)
    {
        // Validasi input
        $request->validate([
            'item_code' => ['required', 'string', 'max:50', Rule::unique('tb_items')->ignore($item->id_item, 'id_item')],
            'item_name' => 'required|string|max:100',
            'id_category' => 'nullable|exists:tb_categories,id_category',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // Update data
        $item->update($request->all());

        return redirect()->route('items.index')
                         ->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Menghapus barang dari database.
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')
                         ->with('success', 'Data barang berhasil dihapus.');
    }
}