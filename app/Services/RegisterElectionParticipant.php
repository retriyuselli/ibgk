<?php

namespace App\Services;

use App\Models\Election;
use App\Models\Participant;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class RegisterElectionParticipant
{
    public function __construct(
        private StoreCompressedImage $photoStorage,
    ) {}

    public function isRegistrationOpen(?Election $election): bool
    {
        if (! $election || ! $election->is_active) {
            return false;
        }

        if ($election->status !== 'open') {
            return false;
        }

        $now = now();

        if ($election->registration_start && $now->lt($election->registration_start)) {
            return false;
        }

        if ($election->registration_end && $now->gt($election->registration_end)) {
            return false;
        }

        return true;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(
        Election $election,
        array $data,
        ?UploadedFile $photo = null,
        ?UploadedFile $photoFullBody = null,
    ): Participant {
        if (! $this->isRegistrationOpen($election)) {
            throw new RuntimeException('Pendaftaran Pemilihan BGK saat ini belum dibuka atau sudah ditutup.');
        }

        $participant = Participant::query()->create([
            'election_id' => $election->id,
            'registration_number' => $this->nextRegistrationNumber($election),
            'gender' => $data['gender'],
            'religion' => $data['religion'] ?? null,
            'full_name' => $data['full_name'],
            'nickname' => $data['nickname'] ?? null,
            'slug' => $this->uniqueParticipantSlug($data['full_name'], $election->year),
            'photo' => $this->storePhoto($photo, 'photo'),
            'photo_full_body' => $this->storePhoto($photoFullBody, 'photo_full_body'),
            'birth_place' => $data['birth_place'] ?? null,
            'birth_date' => $data['birth_date'] ?? null,
            'university' => $data['university'] ?? null,
            'faculty' => $data['faculty'] ?? null,
            'study_program' => $data['study_program'] ?? null,
            'semester' => $data['semester'] ?? null,
            'gpa' => $data['gpa'] ?? null,
            'height_cm' => $data['height_cm'] ?? null,
            'weight_kg' => $data['weight_kg'] ?? null,
            'medical_history' => $data['medical_history'] ?? null,
            'city' => $data['city'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'emergency_phone' => $data['emergency_phone'] ?? null,
            'address' => $data['address'] ?? null,
            'motto' => $data['motto'] ?? null,
            'biography' => $data['biography'] ?? null,
            'instagram' => $data['instagram'] ?? null,
            'tiktok' => $data['tiktok'] ?? null,
            'hobbies' => $data['hobbies'] ?? null,
            'talents' => $data['talents'] ?? null,
            'parent_name' => $data['parent_name'] ?? null,
            'parent_occupation' => $data['parent_occupation'] ?? null,
            'parent_address' => $data['parent_address'] ?? null,
            'motivation' => $data['motivation'] ?? null,
            'ibgk_opinion' => $data['ibgk_opinion'] ?? null,
            'status' => 'registered',
            'current_stage_id' => $election->stages()->orderBy('sort_order')->value('id'),
            'stage_result' => 'pending',
            'is_public' => false,
        ]);

        $this->syncAchievements($participant, $data['achievements'] ?? null);

        return $participant;
    }

    public function nextRegistrationNumber(Election $election): string
    {
        $sequence = Participant::query()
            ->where('election_id', $election->id)
            ->count() + 1;

        return sprintf('BGK-%d-%04d', $election->year, $sequence);
    }

    public function uniqueParticipantSlug(string $name, int $year, ?int $ignoreParticipantId = null): string
    {
        $base = Str::slug($name).'-'.$year;
        $slug = $base;
        $counter = 2;

        while (
            Participant::query()
                ->where('slug', $slug)
                ->when($ignoreParticipantId, fn ($query) => $query->whereKeyNot($ignoreParticipantId))
                ->exists()
        ) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function storePhoto(?UploadedFile $photo, string $field): ?string
    {
        if (! $photo) {
            return null;
        }

        try {
            return $this->photoStorage->store($photo, 'participants/photos');
        } catch (RuntimeException $exception) {
            throw ValidationException::withMessages([
                $field => $exception->getMessage(),
            ]);
        }
    }

    private function syncAchievements(Participant $participant, mixed $achievements): void
    {
        $lines = is_array($achievements)
            ? $achievements
            : preg_split('/\r\n|\r|\n/', (string) $achievements);

        foreach ($lines as $line) {
            $title = trim((string) $line);

            if ($title === '') {
                continue;
            }

            $participant->achievements()->create([
                'title' => $title,
            ]);
        }
    }
}
