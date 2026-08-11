<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->string('tier', 30)->nullable()->after('slug');
            $table->boolean('is_main_sponsor')->default(false)->after('tier');
            $table->boolean('has_showcase_page')->default(false)->after('is_main_sponsor');
            $table->string('tagline')->nullable()->after('description');
            $table->string('hero_image')->nullable()->after('tagline');
            $table->unsignedSmallInteger('showcase_year')->nullable()->after('hero_image');
            $table->text('showcase_intro')->nullable()->after('showcase_year');
            $table->json('showcase_programs')->nullable()->after('showcase_intro');
            $table->json('showcase_timeline')->nullable()->after('showcase_programs');
            $table->json('showcase_benefits')->nullable()->after('showcase_timeline');
            $table->json('showcase_strategic_values')->nullable()->after('showcase_benefits');
            $table->string('external_cta_label')->default('Kunjungi Website Mitra')->after('showcase_strategic_values');
        });
    }

    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn([
                'tier',
                'is_main_sponsor',
                'has_showcase_page',
                'tagline',
                'hero_image',
                'showcase_year',
                'showcase_intro',
                'showcase_programs',
                'showcase_timeline',
                'showcase_benefits',
                'showcase_strategic_values',
                'external_cta_label',
            ]);
        });
    }
};
