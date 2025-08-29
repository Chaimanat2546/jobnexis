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
        Schema::create('media_files', function (Blueprint $table) {
            $table->id('mf_id');
            $table->unsignedBigInteger('mf_m_id'); // media_id
            $table->string('mf_path'); // path ของไฟล์
            $table->string('mf_original_name')->nullable()->after('mf_path'); // ชื่อไฟล์จริง
            $table->string('mf_type')->nullable(); // mime type
            $table->integer('mf_size')->nullable(); // ขนาดไฟล์ (KB)
            $table->timestamps();

            $table->foreign('mf_m_id')->references('m_id')->on('media')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_files');
    }
};
