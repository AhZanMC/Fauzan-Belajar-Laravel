<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
// Import Library Dompdf
use Barryvdh\DomPDF\Facade\Pdf;
// Untuk penyimpanan file
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    // Filtering
    private function getFilteredItems(Request $request)
    {
        $query = Item::with('category');

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($subQ) use ($search) {
                $subQ->where('item_name', 'like', '%' . $search . '%')
                     ->orWhere('item_code', 'like', '%' . $search . '%');
            });
        }

        // Filter Kategori
        if ($categoryId = $request->input('id_category')) {
            $query->where('id_category', $categoryId);
        }

        // Filter Tanggal
        if ($request->input('start_date') && $request->input('end_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'))
                  ->whereDate('created_at', '<=', $request->input('end_date'));
        }

        return $query->latest();
    }
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
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        
        // Panggil fungsi filter privat di atas
        $items = $this->getFilteredItems($request)->paginate($perPage)->withQueryString();
        
        $categories = Category::orderBy('category_name')->get();

        return view('items.index', compact('items', 'categories'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:2048',
        ]);

        // Simpan data baru
        $data = $request->all();

        if ($request->hasFile('image')) {
            // Simpan ke folder public/uploads
            $imagePath = $request->file('image')->store('items', 'public');
            $data['image'] = $imagePath;
        }

        Item::create($data);

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:2048',
        ]);

        // Update data
        $data = $request->all();

        // Logika Ganti Gambar
        if ($request->hasFile('image')) {
            // 1. Hapus gambar lama jika ada
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }
            
            // 2. Upload gambar baru
            $imagePath = $request->file('image')->store('items', 'public');
            $data['image'] = $imagePath;
        }

        $item->update($data);

        return redirect()->route('items.index')
                         ->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Menghapus barang dari database.
     */
    public function destroy(Item $item)
    {
        // Hapus gambar dari penyimpanan jika ada
        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('items.index')
                         ->with('success', 'Data barang berhasil dihapus.');
    }

    /**
     * Fitur Report
     */

    // Export data ke PDF
    public function exportPdf(Request $request)
    {
        // ambil data dengan filter yang sama seperti di index
        $items = $this->getFilteredItems($request)->get();

        // Load view khusus PDF
        $pdf = Pdf::loadView('items.cetakpdf', compact('items'))
                -> setPaper('a4', 'landscape');

        return $pdf->download('laporan-barang-' . date('d-m-Y') . '.pdf');
    }

    // Export data ke Excel
    public function exportExcel(Request $request)
    {
        $items = $this->getFilteredItems($request)->get();
        $filename = 'laporan-barang-' . date('d-m-Y') . '.csv';

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function() use($items) {
            $file = fopen('php://output', 'w');
            // Header CSV
            fputcsv($file, ['No', 'Kode Barang', 'Nama Barang', 'Kategori', 'Stok', 'Harga', 'Deskripsi', 'Tanggal Input']);
            // Isi data
            foreach ($items as $index => $item) {
                fputcsv($file, [
                    $index + 1,
                    $item->item_code,
                    $item->item_name,
                    $item->category ? $item->category->category_name : 'Tidak Ada Kategori',
                    $item->stock,
                    $item->price,
                    $item->description,
                    $item->created_at->format('d-m-Y H:i:s')
                ]);
            }

            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}