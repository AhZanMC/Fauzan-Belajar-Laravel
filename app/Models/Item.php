<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Import class ini
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory;

    // Namam tabel yang terhubung dengan model ini
    protected $table = 'tb_items'; // Nama tabel di database

    // Primary key dari tabel
    protected $primaryKey = 'id_item'; // Nama primary key

    // Atribut yang akan diisi secara massal/bersamaan
    protected $fillable = [
        'item_code',
        'item_name',
        'description',
        'stock',
        'price',
        'id_category', // Tambahkan kolom kategori jika ada relasi
    ];

    // Bikin definisi relasi "BelongTo" (milik satu) ke model Category
    public function category(): BelongsTo 
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }
}
