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
            OrganizationProfileSeeder::class,
            OrganizationPositionSeeder::class,
            HonoraryMemberSeeder::class,
            ActivityCategorySeeder::class,
            NewsCategorySeeder::class,
            PartnerCategorySeeder::class,
            PartnerSeeder::class,
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
