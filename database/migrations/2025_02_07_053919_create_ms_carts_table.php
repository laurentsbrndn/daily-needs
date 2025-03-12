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
        Schema::create('ms_carts', function (Blueprint $table) {
            $table->id('cart_id');
            $table->integer('quantity');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->timestamps();
            
            $table->foreign('customer_id')->references('customer_id')->on('ms_customers')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('ms_products')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_carts');
    }
};
