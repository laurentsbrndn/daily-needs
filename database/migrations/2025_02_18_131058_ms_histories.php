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
        Schema::create('ms_histories', function (Blueprint $table) {
            $table->dateTime('transaction_date', precision: 0);
            $table->decimal('total_price', total: 12, places: 2);
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('shipment_id');
            $table->timestamps();
            
            $table->foreign('customer_id')->references('customer_id')->on('ms_customers')->onDelete('cascade');
            $table->foreign('shipment_id')->references('shipment_id')->on('ms_shipments')->onDelete('cascade');
            $table->foreign('payment_method_id')->references('payment_method_id')->on('ms_payment_methods')->onDelete('cascade');
            $table->foreign('transaction_id')->references('transaction_id')->on('transaction_headers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_histories');
    }
};
