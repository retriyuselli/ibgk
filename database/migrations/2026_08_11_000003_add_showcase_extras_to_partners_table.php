<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->string('showcase_official_title')->nullable()->after('showcase_intro');
            $table->json('showcase_activations')->nullable()->after('showcase_timeline');
            $table->text('showcase_footer_quote')->nullable()->after('showcase_strategic_values');
            $table->text('showcase_privacy_note')->nullable()->after('showcase_footer_quote');
        });
    }

    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn([
                'showcase_official_title',
                'showcase_activations',
                'showcase_footer_quote',
                'showcase_privacy_note',
            ]);
        });
    }
};
