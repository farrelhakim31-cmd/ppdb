<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->foreignId('tahun_ajaran_id')->nullable()->constrained('tahun_ajaran')->onDelete('set null');
            $table->foreignId('agama_id')->nullable()->constrained('agama')->onDelete('set null');
            $table->foreignId('provinsi_id')->nullable()->constrained('provinsi')->onDelete('set null');
            $table->foreignId('kabupaten_id')->nullable()->constrained('kabupaten')->onDelete('set null');
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatan')->onDelete('set null');
            $table->foreignId('kelurahan_id')->nullable()->constrained('kelurahan')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->dropForeign(['tahun_ajaran_id']);
            $table->dropForeign(['agama_id']);
            $table->dropForeign(['provinsi_id']);
            $table->dropForeign(['kabupaten_id']);
            $table->dropForeign(['kecamatan_id']);
            $table->dropForeign(['kelurahan_id']);
            $table->dropColumn(['tahun_ajaran_id', 'agama_id', 'provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id']);
        });
    }
};