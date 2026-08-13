<?php

namespace Database\Seeders\Partners;

use Database\Seeders\Partners\Concerns\SeedsPartnerShowcase;
use Illuminate\Database\Seeder;

class BankingShowcaseSeeder extends Seeder
{
    use SeedsPartnerShowcase;

    public function run(): void
    {
        // Perbankan di-seed oleh MainSponsorSeeder.
    }
}
