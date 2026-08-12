<?php

namespace App\Services;

use App\Models\Alumni;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class AlumniProfileInviteService
{
    public function ensureInvite(Alumni $alumni, ?int $expiresInDays = null): string
    {
        $expiresInDays ??= (int) config('site.alumni_profile_invite_days', 90);

        if ($alumni->hasValidProfileToken()) {
            return $alumni->profileFormUrl();
        }

        $alumni->forceFill([
            'profile_token' => $this->generateUniqueToken(),
            'profile_token_expires_at' => now()->addDays($expiresInDays),
            'profile_invited_at' => now(),
        ])->save();

        return $alumni->fresh()->profileFormUrl();
    }

    public function regenerateInvite(Alumni $alumni, ?int $expiresInDays = null): string
    {
        $expiresInDays ??= (int) config('site.alumni_profile_invite_days', 90);

        $alumni->forceFill([
            'profile_token' => $this->generateUniqueToken(),
            'profile_token_expires_at' => now()->addDays($expiresInDays),
            'profile_invited_at' => now(),
        ])->save();

        return $alumni->fresh()->profileFormUrl();
    }

    public function findByToken(string $token): ?Alumni
    {
        return Alumni::query()
            ->with('batch')
            ->where('profile_token', $token)
            ->first();
    }

    public function isTokenValid(?Alumni $alumni): bool
    {
        return $alumni !== null && $alumni->hasValidProfileToken();
    }

    /** @param  array<string, mixed>  $data */
    public function submitProfile(Alumni $alumni, array $data, ?UploadedFile $photo = null): Alumni
    {
        if ($photo) {
            $data['photo'] = $photo->store('alumni/profiles', 'public');
        }

        unset($data['terms']);

        $alumni->fill($data);

        if (filled($alumni->name)) {
            $alumni->slug = app(PromoteParticipantToAlumni::class)->uniqueSlug(
                $alumni->name,
                $alumni->batch?->year,
                $alumni->id,
            );
        }

        $alumni->profile_submitted_at = now();
        $alumni->save();

        return $alumni->fresh(['batch']);
    }

    private function generateUniqueToken(): string
    {
        do {
            $token = Str::lower(Str::random(48));
        } while (Alumni::query()->where('profile_token', $token)->exists());

        return $token;
    }
}
