<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('master_data', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'kuota', 'biaya', 'jurusan', etc
            $table->string('key');  // 'PPLG', 'pendaftaran', etc
            $table->json('value');  // data value
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->unique(['type', 'key']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_data');
    }
};