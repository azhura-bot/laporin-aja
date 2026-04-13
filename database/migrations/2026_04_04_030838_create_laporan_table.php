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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            
            // Data Pelapor
            $table->string('nama_pelapor');
            $table->string('no_hp', 15);
            $table->string('email');
            
            // Detail Pengaduan
            $table->string('kategori');
            $table->string('lokasi');
            $table->date('tanggal_kejadian');
            $table->string('judul_laporan');
            $table->text('deskripsi');
            $table->string('lampiran')->nullable();
            
            // Status dan Relasi
            $table->enum('status', ['pending', 'diproses', 'selesai'])->default('pending');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
            
            // Index untuk optimasi query
            $table->index('status');
            $table->index('kategori');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
