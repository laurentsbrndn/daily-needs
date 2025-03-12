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
        Schema::create('ms_brands', function (Blueprint $table) {
            $table->id('brand_id')->unique();
            $table->string('brand_name', length: 200)->unique();
            $table->string('brand_slug', length: 200)->unique();
            $table->unsignedBigInteger('company_id');
            $table->timestamps();

            $table->foreign('company_id')->references('company_id')->on('ms_companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_brands');
    }
};
