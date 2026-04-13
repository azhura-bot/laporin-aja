<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            if (!Schema::hasColumn('laporans', 'operator_id')) {
                $table->foreignId('operator_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('laporans', 'catatan_operator')) {
                $table->text('catatan_operator')->nullable()->after('operator_id');
            }

            if (!Schema::hasColumn('laporans', 'bukti_penanganan')) {
                $table->string('bukti_penanganan')->nullable()->after('catatan_operator');
            }

            if (!Schema::hasColumn('laporans', 'ditugaskan_at')) {
                $table->timestamp('ditugaskan_at')->nullable()->after('bukti_penanganan');
            }

            if (!Schema::hasColumn('laporans', 'diproses_at')) {
                $table->timestamp('diproses_at')->nullable()->after('ditugaskan_at');
            }

            if (!Schema::hasColumn('laporans', 'selesai_at')) {
                $table->timestamp('selesai_at')->nullable()->after('diproses_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            if (Schema::hasColumn('laporans', 'operator_id')) {
                $table->dropConstrainedForeignId('operator_id');
            }

            foreach (['catatan_operator', 'bukti_penanganan', 'ditugaskan_at', 'diproses_at', 'selesai_at'] as $column) {
                if (Schema::hasColumn('laporans', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
