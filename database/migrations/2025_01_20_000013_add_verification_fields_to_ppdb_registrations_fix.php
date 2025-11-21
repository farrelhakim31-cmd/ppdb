<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('ppdb_registrations', 'verification_status')) {
                $table->enum('verification_status', ['pending', 'approved', 'rejected', 'revision'])->default('pending');
            }
            if (!Schema::hasColumn('ppdb_registrations', 'verification_notes')) {
                $table->text('verification_notes')->nullable();
            }
            if (!Schema::hasColumn('ppdb_registrations', 'verified_at')) {
                $table->timestamp('verified_at')->nullable();
            }
            if (!Schema::hasColumn('ppdb_registrations', 'verified_by')) {
                $table->unsignedBigInteger('verified_by')->nullable();
                $table->foreign('verified_by')->references('id')->on('users');
            }
        });
    }

    public function down()
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->dropColumn(['verification_status', 'verification_notes', 'verified_at', 'verified_by']);
        });
    }
};