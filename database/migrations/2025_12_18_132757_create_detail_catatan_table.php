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
        Schema::create('detail_catatan', function (Blueprint $table) {
            $table->id('id_detail');
            $table->foreignId('id_catatan')->constrained('catatan_perkembangan', 'id_catatan')->onDelete('cascade');
            $table->foreignId('id_kategori')->constrained('kategori', 'id_kategori')->onDelete('cascade');
            $table->string('deskripsi', 500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_catatan');
    }
};
