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
            $table->bigIncrements('m_id');
            $table->string('m_name');
            $table->text('m_desc')->nullable();
            $table->integer('m_index');
            $table->string('m_path')->nullable();
            $table->unsignedBigInteger('m_l_id')->nullable();
            $table->foreign('m_l_id')
                ->references('l_id')->on('lessons')
                ->onDelete('cascade');
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
