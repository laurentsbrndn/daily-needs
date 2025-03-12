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
        Schema::create('ms_top_ups', function (Blueprint $table) {
            $table->id('top_up_id');
            $table->unsignedDecimal('top_up_amount', total: 12, places: 2);
            $table->dateTime('top_up_date', precision: 0);
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->timestamps();

            $table->foreign('customer_id')->references('customer_id')->on('ms_customers')->onDelete('cascade');
            $table->foreign('payment_method_id')->references('payment_method_id')->on('ms_payment_methods')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_top_ups');
    }
};
