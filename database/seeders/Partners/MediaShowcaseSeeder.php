<?php

namespace Database\Seeders\Partners;

use App\Models\Partner;
use Database\Seeders\Partners\Concerns\SeedsPartnerShowcase;
use Illuminate\Database\Seeder;

class MediaShowcaseSeeder extends Seeder
{
    use SeedsPartnerShowcase;

    public function run(): void
    {
        $this->seedShowcasePartner('media', [
            'tier' => Partner::TIER_PLATINUM,
        ]);
    }
}
