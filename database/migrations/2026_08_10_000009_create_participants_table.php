<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id')->constrained()->cascadeOnDelete();
            $table->string('registration_number')->unique();
            $table->string('gender');
            $table->string('full_name');
            $table->string('slug')->unique();
            $table->string('photo')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('university')->nullable();
            $table->string('faculty')->nullable();
            $table->string('study_program')->nullable();
            $table->unsignedTinyInteger('semester')->nullable();
            $table->string('city')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('motto')->nullable();
            $table->longText('biography')->nullable();
            $table->string('instagram')->nullable();
            $table->string('status')->default('registered');
            $table->boolean('is_public')->default(false);
            $table->timestamps();

            $table->index('gender');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
