<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->string('photo_full_body')->nullable()->after('photo');
            $table->string('nickname')->nullable()->after('full_name');
            $table->string('religion')->nullable()->after('gender');
            $table->string('tiktok')->nullable()->after('instagram');
            $table->decimal('gpa', 3, 2)->nullable()->after('semester');
            $table->unsignedSmallInteger('height_cm')->nullable()->after('gpa');
            $table->decimal('weight_kg', 5, 1)->nullable()->after('height_cm');
            $table->text('medical_history')->nullable()->after('weight_kg');
            $table->string('emergency_phone')->nullable()->after('phone');
            $table->text('hobbies')->nullable()->after('biography');
            $table->text('talents')->nullable()->after('hobbies');
            $table->string('parent_name')->nullable()->after('talents');
            $table->string('parent_occupation')->nullable()->after('parent_name');
            $table->text('parent_address')->nullable()->after('parent_occupation');
            $table->text('motivation')->nullable()->after('parent_address');
            $table->text('ibgk_opinion')->nullable()->after('motivation');
        });
    }

    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn([
                'photo_full_body',
                'nickname',
                'religion',
                'tiktok',
                'gpa',
                'height_cm',
                'weight_kg',
                'medical_history',
                'emergency_phone',
                'hobbies',
                'talents',
                'parent_name',
                'parent_occupation',
                'parent_address',
                'motivation',
                'ibgk_opinion',
            ]);
        });
    }
};
