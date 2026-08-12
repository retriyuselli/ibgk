<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumni', function (Blueprint $table) {
            $table->string('profile_token', 64)->nullable()->unique()->after('phone');
            $table->timestamp('profile_token_expires_at')->nullable()->after('profile_token');
            $table->timestamp('profile_invited_at')->nullable()->after('profile_token_expires_at');
            $table->timestamp('profile_submitted_at')->nullable()->after('profile_invited_at');
        });
    }

    public function down(): void
    {
        Schema::table('alumni', function (Blueprint $table) {
            $table->dropColumn([
                'profile_token',
                'profile_token_expires_at',
                'profile_invited_at',
                'profile_submitted_at',
            ]);
        });
    }
};
