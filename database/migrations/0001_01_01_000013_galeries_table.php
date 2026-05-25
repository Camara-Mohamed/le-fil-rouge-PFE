<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeries', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->foreignId('training_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('camp_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('announcement_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeries');
    }
};
