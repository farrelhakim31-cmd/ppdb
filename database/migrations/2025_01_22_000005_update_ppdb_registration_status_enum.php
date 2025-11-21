<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->enum('status', [
                'draft',
                'dikirim', 
                'verifikasi_administrasi',
                'menunggu_pembayaran',
                'terbayar',
                'verifikasi_keuangan',
                'lulus',
                'tidak_lulus',
                'cadangan'
            ])->default('draft');
        });
    }

    public function down(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->enum('status', ['pending', 'verified', 'accepted', 'rejected'])->default('pending');
        });
    }
};