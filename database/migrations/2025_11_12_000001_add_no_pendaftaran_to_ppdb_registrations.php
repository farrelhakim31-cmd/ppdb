<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('ppdb_registrations', 'no_pendaftaran')) {
                $table->string('no_pendaftaran')->nullable()->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            if (Schema::hasColumn('ppdb_registrations', 'no_pendaftaran')) {
                $table->dropColumn('no_pendaftaran');
            }
        });
    }
};