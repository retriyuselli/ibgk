<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedSmallInteger('year')->index();
            $table->string('theme')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->dateTime('registration_start')->nullable();
            $table->dateTime('registration_end')->nullable();
            $table->date('grand_final_date')->nullable();
            $table->string('location')->nullable();
            $table->string('poster')->nullable();
            $table->string('banner')->nullable();
            $table->string('status')->default('draft');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elections');
    }
};
