<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('verification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ppdb_registration_id')->constrained()->onDelete('cascade');
            $table->foreignId('verifier_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['approved', 'rejected', 'revision']);
            $table->text('notes');
            $table->timestamp('verified_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('verification_logs');
    }
};