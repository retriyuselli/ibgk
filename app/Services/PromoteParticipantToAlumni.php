<?php

namespace App\Services;

use App\Models\Alumni;
use App\Models\AlumniBatch;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;

class PromoteParticipantToAlumni
{
    /**
     * @param  array{alumni_batch_id?: int|null, is_public?: bool, is_active?: bool}  $options
     */
    public function handle(Participant $participant, array $options = []): Alumni
    {
        if ($participant->alumni()->exists()) {
            throw new RuntimeException('Peserta ini sudah terhubung dengan data alumni.');
        }

        if (! in_array($participant->status, ['finalist', 'winner'], true)) {
            throw new InvalidArgumentException('Hanya finalis atau pemenang yang dapat dijadikan alumni.');
        }

        $batchId = $options['alumni_batch_id'] ?? null;

        if (blank($batchId)) {
            $batchId = AlumniBatch::query()
                ->where('election_id', $participant->election_id)
                ->orderByDesc('year')
                ->value('id');
        }

        if (blank($batchId)) {
            throw new RuntimeException('Angkatan untuk Pemilihan ini belum tersedia. Buat Angkatan terlebih dahulu.');
        }

        $batch = AlumniBatch::query()->findOrFail($batchId);

        return DB::transaction(function () use ($participant, $batch, $options): Alumni {
            return Alumni::query()->create([
                'alumni_batch_id' => $batch->id,
                'participant_id' => $participant->id,
                'gender' => $participant->gender,
                'name' => $participant->full_name,
                'slug' => $this->uniqueSlug($participant->full_name, $batch->year),
                'photo' => $participant->photo,
                'university' => $participant->university,
                'faculty' => $participant->faculty,
                'study_program' => $participant->study_program,
                'city' => $participant->city,
                'bio' => $participant->biography,
                'instagram' => $participant->instagram,
                'email' => $participant->email,
                'phone' => $participant->phone,
                'is_public' => (bool) ($options['is_public'] ?? false),
                'is_active' => (bool) ($options['is_active'] ?? true),
            ]);
        });
    }

    public function uniqueSlug(string $name, ?int $year = null): string
    {
        $base = Str::slug($name);

        if (filled($year)) {
            $base = "{$base}-{$year}";
        }

        $slug = $base;
        $counter = 2;

        while (Alumni::query()->where('slug', $slug)->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
