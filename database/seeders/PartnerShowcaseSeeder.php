<?php

namespace Database\Seeders;

use Database\Seeders\Partners\BumnShowcaseSeeder;
use Database\Seeders\Partners\CampusShowcaseSeeder;
use Database\Seeders\Partners\CommunityShowcaseSeeder;
use Database\Seeders\Partners\CorporateShowcaseSeeder;
use Database\Seeders\Partners\GovernmentShowcaseSeeder;
use Database\Seeders\Partners\HotelShowcaseSeeder;
use Database\Seeders\Partners\MediaShowcaseSeeder;
use Illuminate\Database\Seeder;

class PartnerShowcaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            MainSponsorSeeder::class,
            MediaShowcaseSeeder::class,
            CorporateShowcaseSeeder::class,
            HotelShowcaseSeeder::class,
            GovernmentShowcaseSeeder::class,
            BumnShowcaseSeeder::class,
            CampusShowcaseSeeder::class,
            CommunityShowcaseSeeder::class,
        ]);
    }
}
