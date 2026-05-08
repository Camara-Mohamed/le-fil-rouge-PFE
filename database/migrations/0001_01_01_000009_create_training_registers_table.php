<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_registers', function (Blueprint $table) {
            $table->id();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'accepted', 'refused'])->default('pending');
            $table->foreignId('training_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->unique(['training_id', 'user_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_registers');
    }
};
