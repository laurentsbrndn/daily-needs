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
        Schema::create('ms_customers', function (Blueprint $table) {
            $table->id('customer_id')->unique();
            $table->string('customer_first_name', length: 200);
            $table->string('customer_last_name', length: 200);
            $table->string('customer_email', length: 200)->unique();
            $table->string('customer_password', length: 200);
            $table->string('customer_phone_number', length: 200);
            $table->text('customer_address');
            $table->string('customer_photo', length: 200)->nullable();
            $table->enum('customer_gender', ['Male', 'Female', 'Prefer not to say']);
            $table->decimal('customer_balance', total: 12, places: 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_customers');
    }
};
