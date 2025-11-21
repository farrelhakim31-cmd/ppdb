<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->string('major')->after('school_origin');
        });
    }

    public function down(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->dropColumn('major');
        });
    }
};