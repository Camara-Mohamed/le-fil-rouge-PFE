<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formation_user', function (Blueprint $table) {
            $table->id();
            $table->unique(['formation_id', 'user_id']);
            $table->enum('status', ['pending', 'accepted', 'refused'])->default('pending');
            $table->foreignId('formation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formation_user');
    }
};
