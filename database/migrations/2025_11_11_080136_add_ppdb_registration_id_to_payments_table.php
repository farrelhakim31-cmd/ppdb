<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('ppdb_registration_id')->nullable()->constrained('ppdb_registrations')->onDelete('cascade');
            $table->foreignId('student_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['ppdb_registration_id']);
            $table->dropColumn('ppdb_registration_id');
        });
    }
};