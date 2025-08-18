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
        Schema::create('education_profile', function (Blueprint $table) {
            $table->id('e_id');
            $table->string('e_name');
            $table->string('e_phone')->nullable();
            $table->string('e_email')->nullable();
            $table->string('e_website')->nullable();
            $table->date('e_birthday')->nullable();
            $table->string('e_number')->nullable();
            $table->string('e_address')->nullable();
            $table->string('e_province')->nullable();
            $table->text('e_detail')->nullable();

            // ความสัมพันธ์กับ users
            $table->unsignedBigInteger('e_u_id');
            $table->foreign('e_u_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_profile');
    }
};
