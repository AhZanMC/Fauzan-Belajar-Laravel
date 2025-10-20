<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_items', function (Blueprint $table) {
            // Ini buat kolom foreign key ke tb_categories, pakai unsignedBigInteger karena id_category itu bigIncrements biar cocok
            $table->unsignedBigInteger('id_category')->nullable()->after('id_item'); // Taruh setelah id_item, boleh null dulu
        
            $table->foreign('id_category') // Kolom di tabel ini (tb_items)
                  ->references('id_category') // Mereferensi kolom di tabel lain
                  ->on('tb_categories')
                  ->onDelete('set null') // Kalau kategori dihapus, set id_category jadi null (bisa juga 'cascade', 'restrict')
                  ->onUpdate('cascade'); // Aksi jika id_category di tb_categories diupdate
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_items', function (Blueprint $table) {
            // Hapus foreign key dulu (nama constraint biasanya: namatabel_kolomforeign_foreign)
            $table->dropForeign(['id_category']);
            // Hapus kolomnya
            $table->dropColumn('id_category');
        });
    }
};
