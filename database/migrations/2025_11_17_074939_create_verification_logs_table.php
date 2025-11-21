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
            $table->unsignedBigInteger('registration_id');
            $table->unsignedBigInteger('verifier_id');
            $table->enum('status', ['lulus', 'tolak', 'perbaikan']);
            $table->text('notes');
            $table->timestamp('created_at');
            
            $table->foreign('registration_id')->references('id')->on('ppdb_registrations');
            $table->foreign('verifier_id')->references('id')->on('users');
        });

        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->enum('verification_status', ['lulus', 'tolak', 'perbaikan'])->nullable();
            $table->text('verification_notes')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('verification_logs');
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->dropColumn(['verification_status', 'verification_notes']);
        });
    }
};