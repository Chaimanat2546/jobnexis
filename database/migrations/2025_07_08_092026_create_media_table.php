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
        Schema::create('media', function (Blueprint $table) {
            $table->id('m_id');
            $table->string('m_name');
            $table->text('m_desc')->nullable();
            $table->integer('m_index');
            $table->string('m_path')->nullable();
            $table->foreignId('m_l_id')->nullable()->constrained('lessons')->onDelete('cascade');
            $table->unsignedBigInteger('m_c_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }  
};
