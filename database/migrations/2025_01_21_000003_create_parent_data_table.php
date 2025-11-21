<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parent_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftar_id');
            $table->string('nama_ayah', 120);
            $table->string('pekerjaan_ayah', 100);
            $table->string('hp_ayah', 20);
            $table->string('nama_ibu', 120);
            $table->string('pekerjaan_ibu', 100);
            $table->string('hp_ibu', 20);
            $table->string('wali_nama', 120)->nullable();
            $table->string('wali_hp', 20)->nullable();
            $table->timestamps();
            
            $table->foreign('pendaftar_id')->references('id')->on('ppdb_registrations');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parent_data');
    }
};