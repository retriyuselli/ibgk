<?php

namespace Database\Seeders;

use App\Models\OrganizationPeriod;
use Illuminate\Database\Seeder;

class OrganizationPeriodSeeder extends Seeder
{
    public function run(): void
    {
        if (OrganizationPeriod::query()->exists()) {
            return;
        }

        OrganizationPeriod::query()->create([
            'name' => 'Pengurus IBGK Sumatera Selatan',
            'start_year' => 2024,
            'end_year' => 2026,
            'is_active' => true,
        ]);
    }
}
