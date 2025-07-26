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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            // Ini adalah Foreign Key (Kunci Asing)
            // Menghubungkan item ini ke sebuah kategori
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

            // Menghubungkan item ini ke sebuah lokasi
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // Nanti akan kita isi path/nama file gambar
            $table->string('item_code')->unique(); // Kode barang, harus unik (tidak boleh ada yang sama)
            $table->date('purchase_date'); // Tanggal pembelian

            // Kolom enum untuk pilihan yang sudah pasti
            $table->enum('status', ['Tersedia', 'Dipinjam', 'Perbaikan'])->default('Tersedia');
            $table->enum('condition', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
