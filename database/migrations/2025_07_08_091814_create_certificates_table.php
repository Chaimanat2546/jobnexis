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
            $table->id('cer_id');
            $table->string('cer_image');
            $table->foreignId('cer_u_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('cer_c_id')->references('c_id')->on('courses')->onDelete('cascade');
            $table->boolean('cer_publiced')->default(false);
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
