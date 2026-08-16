<?php

namespace Database\Seeders;

use App\Models\AlumniBatch;
use Illuminate\Database\Seeder;

class AlumniBatchSeeder extends Seeder
{
    public function run(): void
    {
        AlumniBatch::syncElectionYearBatches();
        AlumniBatch::syncFoundersBatch();
        AlumniBatch::syncHonoraryBatch();
    }
}
