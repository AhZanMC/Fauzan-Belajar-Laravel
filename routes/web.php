<?php

use Illuminate\Support\Facades\Route;
// Panggil Controller
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;

// 

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

// Bawaan Laravel (Default Laravel)
// Route::get('/', function () {
//     return view('welcome');
// });

// Halaman Utama
Route::get('/', [ItemController::class, 'home'])->name('home');

// --- PENGELOLAAN BARANG (ITEMS) ---
// Route untuk ItemController
Route::resource('items', ItemController::class);

// Route untuk CategoryController
Route::resource('categories', CategoryController::class);