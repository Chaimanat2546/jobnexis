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
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('c_id');
            $table->string('c_name');
            $table->text('c_description')->nullable();
            $table->string('c_code')->unique();
            $table->enum('c_status', ['open','draft','closed','pending'])->default('draft');
            $table->string('c_image')->nullable();
            $table->timestamps();
            $table->foreignId('c_create_by_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
