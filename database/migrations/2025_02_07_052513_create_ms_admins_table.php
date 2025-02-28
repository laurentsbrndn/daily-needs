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
        Schema::create('ms_admins', function (Blueprint $table) {
            $table->id('admin_id')->unique();
            $table->string('admin_first_name', length: 200);
            $table->string('admin_last_name', length: 200);
            $table->string('admin_email', length: 200)->unique();
            $table->string('admin_password', length: 200);
            $table->string('admin_phone_number', length: 200);
            $table->text('admin_address'); 
            $table->string('admin_photo', length: 200)->nullable();
            $table->enum('admin_gender', ['Male', 'Female', 'Prefer not to say']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_admins');
    }
};
