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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', [
                'arrivant', 'animateur_1', 'animateur_2', 'brevete', 'coordinateur', 'formateur', 'admin'])->default('arrivant');
            $table->enum('status', ['incomplet', 'pending', 'complet', 'archived'])->default('pending');
            $table->string('phone')->unique()->nullable();
            $table->date('birth_date')->default(now());
            $table->string('address')->nullable();
            $table->string('number')->nullable();
            $table->string('city')->nullable();
            $table->enum('province', ['liege', 'namur', 'luxembourg', 'hainaut', 'brabant_wallon', 'anvers', 'limbourg', 'flandre_orientale', 'flandre_occidentale', 'bruxelles', 'brabant_flamand'])->default('liege');
            $table->string('postal_code')->nullable();
            $table->enum('diet', ['normal', 'vegetarian', 'vegan', 'halal', 'kosher', 'gluten_free', 'lactose_free', 'other'])->default('normal');
            $table->text('allergies')->nullable();
            $table->string('avatar_path')->nullable();
            $table->rememberToken();
            $table->timestamps();
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
