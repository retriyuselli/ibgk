<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->after('election_id')
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('current_stage_id')
                ->nullable()
                ->after('status')
                ->constrained('election_stages')
                ->nullOnDelete();

            $table->string('stage_result')->default('pending')->after('current_stage_id');
            $table->text('stage_notes')->nullable()->after('stage_result');

            $table->index('user_id');
            $table->unique(['election_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropUnique(['election_id', 'email']);
            $table->dropConstrainedForeignId('current_stage_id');
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn(['stage_result', 'stage_notes']);
        });
    }
};
