<?php

use App\Models\Alumni;
use App\Models\AlumniBatch;
use App\Models\HonoraryMember;
use App\Services\PromoteParticipantToAlumni;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $batch = AlumniBatch::honoraryBatch();

        if (! $batch) {
            return;
        }

        $slugs = app(PromoteParticipantToAlumni::class);
        $existingNames = Alumni::query()
            ->where('alumni_batch_id', $batch->id)
            ->pluck('name')
            ->map(fn (string $name): string => mb_strtolower(trim($name), 'UTF-8'))
            ->all();

        HonoraryMember::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->each(function (HonoraryMember $member) use ($batch, $slugs, &$existingNames): void {
                $key = mb_strtolower(trim($member->name), 'UTF-8');

                if (in_array($key, $existingNames, true)) {
                    return;
                }

                Alumni::query()->create([
                    'alumni_batch_id' => $batch->id,
                    'gender' => $this->guessGender($member->name),
                    'name' => $member->name,
                    'slug' => $slugs->uniqueSlug($member->name, $batch->year),
                    'photo' => $member->photo,
                    'profession' => filled($member->title) ? $member->title : 'Anggota Kehormatan IBGK Sumsel',
                    'bio' => $member->description,
                    'is_public' => true,
                    'is_active' => true,
                    'profile_submitted_at' => now(),
                ]);

                $existingNames[] = $key;
            });
    }

    public function down(): void
    {
        // Data migration is not reversed automatically.
    }

    private function guessGender(string $name): string
    {
        $haystack = mb_strtolower($name, 'UTF-8');

        foreach (['adisti', 'amaliah', 'sari', 'putri', 'ayu', 'ningrum'] as $needle) {
            if (str_contains($haystack, $needle)) {
                return 'gadis';
            }
        }

        return 'bujang';
    }
};
