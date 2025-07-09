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
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id('w_id');
            $table->string('w_name');
            $table->integer('w_year');
            $table->integer('w_amount');
            $table->string('w_u_duties')->nullable();
            $table->foreignId('w_u_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};
