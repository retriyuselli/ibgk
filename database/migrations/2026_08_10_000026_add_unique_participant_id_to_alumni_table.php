<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $duplicates = DB::table('alumni')
            ->select('participant_id', DB::raw('COUNT(*) as total'))
            ->whereNotNull('participant_id')
            ->groupBy('participant_id')
            ->having('total', '>', 1)
            ->count();

        if ($duplicates > 0) {
            throw new RuntimeException(
                'Tidak dapat menambahkan unique constraint pada alumni.participant_id karena masih ada data duplikat.'
            );
        }

        Schema::table('alumni', function (Blueprint $table) {
            $table->unique('participant_id');
        });
    }

    public function down(): void
    {
        Schema::table('alumni', function (Blueprint $table) {
            $table->dropUnique(['participant_id']);
        });
    }
};
