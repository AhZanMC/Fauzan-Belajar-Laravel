<?php

use App\Http\Controllers\ProfileController; // Bawaan Laravel Breeze
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // kalo user dah login
    if(Auth::check()){
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    // Ambil data di controller
    $items = \App\Models\Item::latest()->get();
    $categories = \App\Models\Category::latest()->get();
    // kirim data ke view
    return view('dashboard', compact('items', 'categories'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Halaman Kelola Data (Wajib Login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Area CRUD
    Route::resource('items', ItemController::class);
    Route::resource('categories', CategoryController::class);
});

require __DIR__.'/auth.php';
