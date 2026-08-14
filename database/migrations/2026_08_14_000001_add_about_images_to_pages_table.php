<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('about_image_1')->nullable()->after('banner');
            $table->string('about_image_2')->nullable()->after('about_image_1');
            $table->string('about_image_3')->nullable()->after('about_image_2');
            $table->string('about_image_4')->nullable()->after('about_image_3');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['about_image_1', 'about_image_2', 'about_image_3', 'about_image_4']);
        });
    }
};
