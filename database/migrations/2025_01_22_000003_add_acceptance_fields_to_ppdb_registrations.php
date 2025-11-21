<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->timestamp('accepted_at')->nullable()->after('verified_by');
            $table->unsignedBigInteger('accepted_by')->nullable()->after('accepted_at');
            
            $table->foreign('accepted_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->dropForeign(['accepted_by']);
            $table->dropColumn(['accepted_at', 'accepted_by']);
        });
    }
};