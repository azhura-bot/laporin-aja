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
        Schema::create('daerah_butuh_relawan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_daerah');
            $table->string('provinsi');
            $table->text('deskripsi')->nullable();
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi', 'kritis'])->default('sedang');
            $table->integer('relawan_dibutuhkan')->default(0);
            $table->integer('relawan_terdaftar')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            $table->index(['provinsi', 'prioritas']);
            $table->index('aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daerah_butuh_relawan');
    }
};
