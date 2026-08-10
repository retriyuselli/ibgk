<?php

namespace App\Services;

use App\Models\Election;
use App\Models\Participant;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use RuntimeException;

class RegisterElectionParticipant
{
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
    public function handle(Election $election, array $data, ?UploadedFile $photo = null): Participant
    {
        if (! $this->isRegistrationOpen($election)) {
            throw new RuntimeException('Pendaftaran Pemilihan BGK saat ini belum dibuka atau sudah ditutup.');
        }

        $photoPath = $photo?->store('participants/photos', 'public');

        return Participant::query()->create([
            'election_id' => $election->id,
            'registration_number' => $this->nextRegistrationNumber($election),
            'gender' => $data['gender'],
            'full_name' => $data['full_name'],
            'slug' => $this->uniqueParticipantSlug($data['full_name'], $election->year),
            'photo' => $photoPath,
            'birth_place' => $data['birth_place'] ?? null,
            'birth_date' => $data['birth_date'] ?? null,
            'university' => $data['university'] ?? null,
            'faculty' => $data['faculty'] ?? null,
            'study_program' => $data['study_program'] ?? null,
            'semester' => $data['semester'] ?? null,
            'city' => $data['city'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'motto' => $data['motto'] ?? null,
            'biography' => $data['biography'] ?? null,
            'instagram' => $data['instagram'] ?? null,
            'status' => 'registered',
            'is_public' => false,
        ]);
    }

    public function nextRegistrationNumber(Election $election): string
    {
        $sequence = Participant::query()
            ->where('election_id', $election->id)
            ->count() + 1;

        return sprintf('BGK-%d-%04d', $election->year, $sequence);
    }

    public function uniqueParticipantSlug(string $name, int $year): string
    {
        $base = Str::slug($name).'-'.$year;
        $slug = $base;
        $counter = 2;

        while (Participant::query()->where('slug', $slug)->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
