<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerLogoSeeder extends Seeder
{
    public function run(): void
    {
        Partner::query()->update(['logo' => null]);
    }
}
