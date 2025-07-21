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
        Schema::create('companies_profiles', function (Blueprint $table) {
            $table->id('co_id');
            $table->string('co_name');
            $table->string('co_logo')->nullable();
            $table->string('co_tagline')->nullable();
            $table->text('co_description')->nullable();
            $table->string('co_website')->nullable();
            $table->string('co_email')->nullable();
            $table->string('co_phone')->nullable();
            $table->string('co_address')->nullable();
            $table->string('co_city')->nullable();
            $table->string('co_country')->nullable();
            $table->date('co_founded_at')->nullable();
            $table->foreignId('co_user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies_profiles');
    }
};
