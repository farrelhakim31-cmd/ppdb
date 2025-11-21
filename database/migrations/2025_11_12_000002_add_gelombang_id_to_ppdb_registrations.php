<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('ppdb_registrations', 'gelombang_id')) {
                $table->unsignedBigInteger('gelombang_id')->nullable()->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            if (Schema::hasColumn('ppdb_registrations', 'gelombang_id')) {
                $table->dropColumn('gelombang_id');
            }
        });
    }
};