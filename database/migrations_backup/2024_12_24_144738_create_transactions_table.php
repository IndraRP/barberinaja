<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('barber_id')->constrained('barbers');
            $table->string('name_customer')->nullable();
            $table->bigInteger('phone_number')->nullable();
            $table->date('appointment_date');
            $table->time('time')->nullable();
            $table->enum('status', ['pending', 'approved', 'completed', 'canceled', 'arrived'])->default('pending');
            $table->enum('canceled', ['payment', 'timeout', 'not_paid'])->default(null);
            $table->string('bukti_image')->nullable();
            $table->enum('status', ['BRI', 'BNI', 'BCA']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
