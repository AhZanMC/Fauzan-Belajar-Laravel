<?php

namespace App\Http\Controllers;

// Panggil model Item
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ambil semua data item
        $items = Item::with('category')->latest()->get();

        // Untuk sekarang, kita coba tampilkan dalam bentuk JSON dulu untuk testing
        // return response()->json([
        //     'message' => 'Data item berhasil diambil',
        //     'data' => $items
        // ]);
        
        // Kirim data items ke view
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ambil daftar kategori untuk select di form (gunakan FQCN agar tidak perlu menambah use di atas)
        $categories = \App\Models\Category::all();

        return view('items.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $item = Item::create($validated);

        return redirect()->route('items.index')
            ->with('success', 'Item berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::with('category')->findOrFail($id);

        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Item::findOrFail($id);
        $categories = \App\Models\Category::all();

        return view('items.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Item::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $item->update($validated);

        return redirect()->route('items.index')
            ->with('success', 'Item berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('items.index')
            ->with('success', 'Item berhasil dihapus.');
    }
}
