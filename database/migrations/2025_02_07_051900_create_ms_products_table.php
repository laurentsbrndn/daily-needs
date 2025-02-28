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
            $table->decimal('product_price', total: 12, places: 2);
            $table->integer('product_stock');
            $table->string('product_image', length: 200);
            $table->text('product_description');
            $table->string('product_slug', length: 200)->unique();
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreign('brand_id')->references('brand_id')->on('ms_brands')->onDelete('cascade');
            $table->foreign('category_id')->references('category_id')->on('ms_categories')->onDelete('cascade');
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
