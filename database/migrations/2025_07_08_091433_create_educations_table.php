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
        Schema::create('educations', function (Blueprint $table) {
            $table->id('ed_id');
            $table->string('ed_name');
            $table->date('start_date')->nullable(false);
            $table->date('end_date')->nullable(false);
            $table->string('e_degree');
            $table->foreignId('ed_u_id')->constrained('users')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
