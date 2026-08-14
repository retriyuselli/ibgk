<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PageSeeder::class,
            OrganizationProfileSeeder::class,
            OrganizationPositionSeeder::class,
            OrganizationPeriodSeeder::class,
            HonoraryMemberSeeder::class,
            ActivityCategorySeeder::class,
            NewsCategorySeeder::class,
            PartnerCategorySeeder::class,
            PartnerSeeder::class,
            PartnerShowcaseSeeder::class,
            PartnerLogoSeeder::class,
            AlumniBatchSeeder::class,
            AlumniSeeder::class,
            ActivitySeeder::class,
            GalleryAlbumSeeder::class,
            NewsSeeder::class,
            ElectionSeeder::class,
            DocumentSeeder::class,
            ParticipantSeeder::class,
        ]);
    }
}
