<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

class DashboardController extends Controller
{
    // Tampilkan dashboard
    public function index()
    {
        // logika ambil data
        $items = Item::with('category')->latest()->get();
        $categories = Category::latest()->get();

        // Kirim data ke view
        return view('dashboard', compact('items', 'categories'));
    }
}
