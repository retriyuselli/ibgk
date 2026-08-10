<?php

namespace Database\Seeders;

use App\Models\AlumniBatch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AlumniBatchSeeder extends Seeder
{
    public function run(): void
    {
        $batches = [
            2002 => 24,
            2003 => 24,
            2004 => 24,
            2005 => 30,
            2006 => 30,
            2007 => 30,
            2008 => 30,
            2009 => 30,
            2010 => 30,
            2011 => 30,
        ];

        foreach ($batches as $year => $count) {
            $name = "BGK Sumsel {$year}";

            AlumniBatch::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'year' => $year,
                    'historical_member_count' => $count,
                    'is_active' => true,
                ]
            );
        }
    }
}
