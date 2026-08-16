<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('election_stages', function (Blueprint $table) {
            $table->text('location')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('election_stages', function (Blueprint $table) {
            $table->dropColumn('location');
        });
    }
};
