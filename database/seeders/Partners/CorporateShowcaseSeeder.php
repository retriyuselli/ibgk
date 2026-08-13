<?php

namespace Database\Seeders\Partners;

use App\Models\Partner;
use Database\Seeders\Partners\Concerns\SeedsPartnerShowcase;
use Illuminate\Database\Seeder;

class CorporateShowcaseSeeder extends Seeder
{
    use SeedsPartnerShowcase;

    public function run(): void
    {
        $this->seedShowcasePartner('corporate', [
            'tier' => Partner::TIER_GOLD,
        ]);
    }
}
