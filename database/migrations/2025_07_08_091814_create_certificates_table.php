<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->increments('cer_id');
            $table->string('cer_image');
            $table->unsignedInteger('cer_u_id');
            $table->unsignedInteger('cer_c_id');
            $table->boolean('cer_publiced')->default(false);

            // Foreign key เชื่อมไปตาราง users
            $table->foreign('cer_u_id')->references('id')->on('users')->onDelete('cascade');

            // Foreign key เชื่อมไปตาราง courses
            $table->foreign('cer_c_id')->references('c_id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
