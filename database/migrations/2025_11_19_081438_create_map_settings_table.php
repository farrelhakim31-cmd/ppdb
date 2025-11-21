<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('map_settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_name')->default('SMK Bakti Nusantara 666');
            $table->text('school_address');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->integer('zoom_level')->default(13);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('map_settings');
    }
};