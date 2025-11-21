<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registration_documents', function (Blueprint $table) {
            $table->enum('jenis', ['IJAZAH', 'RAPOR', 'KIP', 'KKS', 'AKTA', 'KK', 'PAS_FOTO', 'LAINNYA'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('registration_documents', function (Blueprint $table) {
            $table->enum('jenis', ['IJAZAH', 'RAPOR', 'KIP', 'KKS', 'AKTA', 'KK', 'LAINNYA'])->change();
        });
    }
};