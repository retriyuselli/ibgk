<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organization_profiles', function (Blueprint $table) {
            $table->json('showcase_copy')->nullable()->after('facebook');
            $table->string('showcase_hero_background')->nullable()->after('showcase_copy');
        });
    }

    public function down(): void
    {
        Schema::table('organization_profiles', function (Blueprint $table) {
            $table->dropColumn(['showcase_copy', 'showcase_hero_background']);
        });
    }
};
