<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Namam tabel yang terhubung dengan model ini
    protected $table = 'tb_categories'; // Nama tabel di database

    // Primary key dari tabel
    protected $primaryKey = 'id_category'; // Nama primary key

    // Atribut yang akan diisi secara massal/bersamaan
    protected $fillable = [
        'category_name',
    ];

    // Bikin definisi relasi "HasMany" (memiliki banyak) ke model Item
    public function items(): HasMany 
    {
        return $this->hasMany(Item::class, 'id_category', 'id_category');
    }
}
