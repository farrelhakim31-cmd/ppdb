<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop existing table if exists
        Schema::dropIfExists('verification_logs');
        
        // Create new table with correct structure
        Schema::create('verification_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ppdb_registration_id');
            $table->unsignedBigInteger('verifier_id');
            $table->enum('status', ['approved', 'rejected', 'revision']);
            $table->text('notes');
            $table->timestamp('verified_at');
            $table->timestamps();
            
            $table->foreign('ppdb_registration_id')->references('id')->on('ppdb_registrations')->onDelete('cascade');
            $table->foreign('verifier_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('verification_logs');
    }
};