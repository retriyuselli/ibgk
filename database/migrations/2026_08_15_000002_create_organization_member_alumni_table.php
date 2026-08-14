<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_member_alumni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('alumni_id')->constrained('alumni')->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['organization_member_id', 'alumni_id'], 'org_member_alumni_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_member_alumni');
    }
};
