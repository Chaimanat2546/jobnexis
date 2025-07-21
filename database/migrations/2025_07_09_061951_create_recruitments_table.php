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
        Schema::create('recruitments', function (Blueprint $table) {
            $table->id('rc_id');
            $table->string('rc_title');
            $table->text('rc_description');
            $table->text('rc_requirements')->nullable();
            $table->string('rc_salary')->nullable(); // "30000" หรือ "ตามตกลง"
            $table->string('rc_location_link');
            $table->enum('rc_type', ['full-time', 'part-time', 'intern', 'freelance'])->default('full-time');
            $table->enum('rc_status', ['open', 'closed', 'draft'])->default('open');
            $table->date('rc_posted_at');
            $table->date('rc_expire_at')->nullable();
            $table->foreignId('rc_co_id')->references('co_id')->on('companies_profiles')->onDelete('cascade');
            $table->foreignId('rc_user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitments');
    }
};
