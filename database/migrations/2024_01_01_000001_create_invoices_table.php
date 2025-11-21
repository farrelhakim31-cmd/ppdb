<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('registration_id')->constrained('ppdb_registrations')->onDelete('cascade');
            $table->string('type');
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['unpaid', 'paid', 'overdue'])->default('unpaid');
            $table->date('due_date');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};