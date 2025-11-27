<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

class DashboardController extends Controller
{
    // Tampilkan dashboard
    public function index(Request $request)
    {
        // Ambil semua input filter dari request
        $search = $request->input('search');
        $categoryId = $request->input('id_category');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Ambil input per_page, default ke 10 jika tidak ada
        $perPage = $request->input('per_page', 10);

        // Validasi input per_page (Security)
        // Pastikan user hanya bisa memilih angka yang diizinkan agar tidak error/berat
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        // Mulai Query Dasar
        // Kita gunakan Eager Loading 'category' agar lebih efisien (mengurangi query N+1)
        $query = Item::with('category');

        // Logika Pencarian (Search)
        $query->when($search, function ($q) use ($search) {
            return $q->where(function ($subQ) use ($search) {
                $subQ->where('item_name', 'like', '%' . $search . '%')
                     ->orWhere('item_code', 'like', '%' . $search . '%');
            });
        });

        // Filter Kategori
        $query->when($categoryId, function ($q) use ($categoryId) {
            return $q->where('id_category', $categoryId);
        });

        // Filter Tanggal (Range)
        if ($startDate && $endDate) {
            $query->whereDate('created_at', '>=', $startDate)
                  ->whereDate('created_at', '<=', $endDate);
        }

        $items = $query->latest()->paginate($perPage)->withQueryString();

        // 8. Ambil data kategori untuk dropdown filter di view
        $categories = Category::orderBy('category_name')->get();
        return view('dashboard', compact('items', 'categories'));
    }
}
