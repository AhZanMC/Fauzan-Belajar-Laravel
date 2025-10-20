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
        Schema::create('tb_categories', function (Blueprint $table) {
            $table->id('id_category'); // Primary key dengan nama kolom 'id_category'
            $table->string('category_name', 100)->unique(); // nama kategori dengan panjang maksimum 100 karakter dan unik
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    // method down() digunakan untuk menghapus tabel yang telah dibuat
    public function down(): void
    {
        Schema::dropIfExists('tb_categories');
    }
};
