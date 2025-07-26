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
        Schema::create('locations', function (Blueprint $table) {
            $table->id(); // Membuat kolom ID auto-increment (primary key)
            $table->string('name', 100); // Kolom untuk nama lokasi, maksimal 100 karakter
            $table->text('description')->nullable(); // Kolom untuk deskripsi, boleh kosong (nullable)
            $table->timestamps(); // Membuat kolom created_at dan updated_at secara otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
