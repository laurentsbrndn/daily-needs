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
        Schema::create('ms_customer_addresses', function (Blueprint $table) {
            $table->id('customer_address_id')->unique();
            $table->string('customer_address_name', length: 200);
            $table->string('customer_address_street', length: 200);
            $table->string('customer_address_postal_code', length: 200);
            $table->string('customer_address_district', length: 200);
            $table->string('customer_address_regency_city', length: 200);
            $table->string('customer_address_province', length: 200);
            $table->string('customer_address_country', length: 200);
            $table->unsignedBigInteger('customer_id');
            $table->timestamps();

            $table->foreign('customer_id')->references('customer_id')->on('ms_customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_addresses');
    }
};
