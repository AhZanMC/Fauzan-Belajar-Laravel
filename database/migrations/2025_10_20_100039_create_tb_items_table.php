<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // method up() digunakan untuk membuat tabel baru
    public function up(): void
    {
        Schema::create('tb_items', function (Blueprint $table) {
            $table->id('id_item'); // Primary key dengan nama kolom 'id_item'
            $table->string('item_code', 50)->unique(); // Kolom item_code dengan panjang maksimum 50 karakter dan unik
            $table->string('item_name', 100); // nama barang
            $table->text('description')->nullable(); // deskripsi barang
            $table->integer('stock')->default(0); // stok barang dengan nilai default 0
            $table->decimal('price', 10, 2)->default(0.00); // harga barang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    // method down() digunakan untuk menghapus tabel yang telah dibuat
    public function down(): void
    {
        Schema::dropIfExists('tb_items');
    }
};
