<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->json('showcase_kpis')->nullable()->after('showcase_benefits');
            $table->json('showcase_targets')->nullable()->after('showcase_kpis');
            $table->text('showcase_program_quote')->nullable()->after('showcase_targets');
            $table->string('showcase_partner_tagline')->nullable()->after('showcase_program_quote');
        });
    }

    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn([
                'showcase_kpis',
                'showcase_targets',
                'showcase_program_quote',
                'showcase_partner_tagline',
            ]);
        });
    }
};
