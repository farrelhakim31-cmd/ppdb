<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registration_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftar_id');
            $table->enum('jenis', ['IJAZAH', 'RAPOR', 'KIP', 'KKS', 'AKTA', 'KK', 'LAINNYA']);
            $table->string('nama_file', 255);
            $table->string('url', 255);
            $table->integer('ukuran_kb');
            $table->boolean('valid')->default(false);
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            $table->foreign('pendaftar_id')->references('id')->on('ppdb_registrations');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_documents');
    }
};