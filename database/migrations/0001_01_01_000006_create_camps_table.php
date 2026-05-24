<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('camps', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('banner')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('type', ['stage', 'sejour'])->default('stage');
            $table->integer('participants')->nullable();
            $table->longText('details')->nullable();
            $table->longText('constraints')->nullable();
            $table->string('address')->nullable();
            $table->string('number')->nullable();
            $table->string('city')->nullable();
            $table->enum('province', ['liege', 'namur', 'luxembourg', 'hainaut', 'brabant_wallon', 'anvers', 'limbourg', 'flandre_orientale', 'flandre_occidentale', 'bruxelles', 'brabant_flamand'])->default('liege');
            $table->integer('postal_code')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->json('roles')->nullable();
            $table->enum('status', ['pending', 'published', 'refused', 'confirmed'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('camps');
    }
};
