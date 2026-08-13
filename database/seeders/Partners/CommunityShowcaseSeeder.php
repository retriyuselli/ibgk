<?php

namespace Database\Seeders\Partners;

use App\Models\Partner;
use Database\Seeders\Partners\Concerns\SeedsPartnerShowcase;
use Illuminate\Database\Seeder;

class CommunityShowcaseSeeder extends Seeder
{
    use SeedsPartnerShowcase;

    public function run(): void
    {
        $this->seedShowcasePartner('community', [
            'tier' => Partner::TIER_GOLD,
            'showcase_kpis' => null,
            'showcase_targets' => null,
        ]);
    }
}
