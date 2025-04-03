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
        Schema::create('ms_products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name', length: 200);
            $table->unsignedDecimal('product_price', total: 12, places: 2);
            $table->unsignedInteger('product_stock');
            $table->string('product_image', length: 200);
            $table->text('product_description');
            $table->string('product_slug', length: 200)->unique();
            $table->enum('product_status', ['Available', 'Out of Stock', 'Discontinued']);
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->timestamps();

            $table->foreign('brand_id')->references('brand_id')->on('ms_brands')->onDelete('set null');
            $table->foreign('category_id')->references('category_id')->on('ms_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_products');
    }
};
