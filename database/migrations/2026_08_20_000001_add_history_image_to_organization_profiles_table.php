<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organization_profiles', function (Blueprint $table) {
            $table->string('history_image')->nullable()->after('logo');
            $table->string('history_image_caption')->nullable()->after('history_image');
        });
    }

    public function down(): void
    {
        Schema::table('organization_profiles', function (Blueprint $table) {
            $table->dropColumn(['history_image', 'history_image_caption']);
        });
    }
};
