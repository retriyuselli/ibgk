<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedSmallInteger('year')->index();
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedInteger('historical_member_count')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_batches');
    }
};
