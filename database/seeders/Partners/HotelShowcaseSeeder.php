<?php

namespace Database\Seeders\Partners;

use App\Models\Partner;
use Database\Seeders\Partners\Concerns\SeedsPartnerShowcase;
use Illuminate\Database\Seeder;

class HotelShowcaseSeeder extends Seeder
{
    use SeedsPartnerShowcase;

    public function run(): void
    {
        $this->seedShowcasePartner('hotel', [
            'tier' => Partner::TIER_PLATINUM,
        ]);
    }
}
