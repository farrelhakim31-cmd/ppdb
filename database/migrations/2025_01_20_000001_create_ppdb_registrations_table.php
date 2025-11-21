<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppdb_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->date('birth_date');
            $table->string('birth_place');
            $table->enum('gender', ['L', 'P']);
            $table->text('address');
            $table->string('school_origin');
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->string('parent_job');
            $table->enum('status', ['pending', 'verified', 'accepted', 'rejected'])->default('pending');
            $table->text('documents')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamps();
            
            $table->foreign('verified_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_registrations');
    }
};