<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->enum('verification_status', ['pending', 'approved', 'rejected', 'revision'])->default('pending');
            $table->text('verification_notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
        });
    }

    public function down()
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->dropColumn(['verification_status', 'verification_notes', 'verified_at', 'verified_by']);
        });
    }
};