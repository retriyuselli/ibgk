<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumni', function (Blueprint $table): void {
            $table->foreignId('user_id')
                ->nullable()
                ->after('participant_id')
                ->constrained()
                ->nullOnDelete();

            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('alumni', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
