<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_divisions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('organization_members', function (Blueprint $table) {
            $table->foreignId('organization_division_id')
                ->nullable()
                ->after('organization_position_id')
                ->constrained('organization_divisions')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('organization_members', function (Blueprint $table) {
            $table->dropConstrainedForeignId('organization_division_id');
        });

        Schema::dropIfExists('organization_divisions');
    }
};
