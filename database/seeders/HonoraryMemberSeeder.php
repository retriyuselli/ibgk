<?php

namespace Database\Seeders;

use App\Models\HonoraryMember;
use Illuminate\Database\Seeder;

class HonoraryMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            'Yul Khaidir, S.H.',
            'Irwan, A.Md.',
            'Adisti Amaliah, S.E.',
            'Eko Wahyu Kusnadi, S.T.',
        ];

        foreach ($members as $index => $name) {
            HonoraryMember::query()->updateOrCreate(
                ['name' => $name],
                [
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
