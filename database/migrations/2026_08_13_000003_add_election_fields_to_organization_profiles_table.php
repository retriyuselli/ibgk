<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organization_profiles', function (Blueprint $table) {
            $table->json('election_copy')->nullable()->after('showcase_hero_background');
            $table->json('election_pillars')->nullable()->after('election_copy');
            $table->string('election_benefits_image')->nullable()->after('election_pillars');
        });
    }

    public function down(): void
    {
        Schema::table('organization_profiles', function (Blueprint $table) {
            $table->dropColumn(['election_copy', 'election_pillars', 'election_benefits_image']);
        });
    }
};
