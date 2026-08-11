<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumni_batches', function (Blueprint $table) {
            $table->string('category', 20)->default('election')->after('slug');
        });
    }

    public function down(): void
    {
        Schema::table('alumni_batches', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
