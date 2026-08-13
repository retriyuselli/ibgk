<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partner_categories', function (Blueprint $table) {
            $table->string('showcase_theme')->default('default')->after('description');
            $table->string('official_partner_label')->nullable()->after('showcase_theme');
            $table->string('default_cta_label')->nullable()->after('official_partner_label');
        });
    }

    public function down(): void
    {
        Schema::table('partner_categories', function (Blueprint $table) {
            $table->dropColumn([
                'showcase_theme',
                'official_partner_label',
                'default_cta_label',
            ]);
        });
    }
};
