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
        Schema::create('ms_couriers', function (Blueprint $table) {
            $table->id('courier_id')->unique();
            $table->string('courier_first_name', length: 200);
            $table->string('courier_last_name', length: 200);
            $table->string('courier_email', length: 200)->unique;
            $table->string('courier_password', length: 200);
            $table->string('courier_phone_number', length: 200);
            $table->text('courier_address');
            $table->string('courier_photo', length: 200)->nullable();
            $table->enum('courier_gender', ['Male', 'Female', 'Prefer not to say']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_couriers');
    }
};
