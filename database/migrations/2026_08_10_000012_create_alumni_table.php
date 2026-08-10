<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_batch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('participant_id')->nullable()->constrained()->nullOnDelete();
            $table->string('gender');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('photo')->nullable();
            $table->string('university')->nullable();
            $table->string('faculty')->nullable();
            $table->string('study_program')->nullable();
            $table->unsignedSmallInteger('graduation_year')->nullable();
            $table->string('profession')->nullable();
            $table->string('company')->nullable();
            $table->string('city')->nullable();
            $table->text('bio')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_public')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('gender');
            $table->index('is_public');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
