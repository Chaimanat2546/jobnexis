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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->enum('role', ['admin', 'education', 'provider', 'jobber'])->default('jobber');
            $table->boolean('is_banned')->default(false);
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id('up_id');
            $table->string('up_prefix')->nullable();
            $table->string('up_first_name')->nullable();
            $table->string('up_last_name')->nullable();
            $table->string('up_uid')->nullable();
            $table->string('up_address')->nullable();
            $table->string('up_city')->nullable();
            $table->string('up_country')->nullable();
            $table->date('up_birth_date')->nullable();
            $table->string('up_gender')->nullable();
            $table->string('up_nationality')->nullable();
            $table->string('up_phone')->nullable();
            $table->foreignId('up_u_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('user_profiles');
    }
};
