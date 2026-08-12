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

    /** @return array<string, mixed> */
    public static function profileValidationRules(bool $requireTerms = true, bool $requireEmail = false): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'university' => ['nullable', 'string', 'max:255'],
            'faculty' => ['nullable', 'string', 'max:255'],
            'study_program' => ['nullable', 'string', 'max:255'],
            'graduation_year' => ['nullable', 'integer', 'min:1999', 'max:'.(now()->year + 10)],
            'profession' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'email' => [$requireEmail ? 'required' : 'nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'photo' => ['nullable', 'image', 'max:5120'],
        ];

        if ($requireTerms) {
            $rules['terms'] = ['accepted'];
        }

        return $rules;
    }

    /** @param  array<string, mixed>  $data */
    public function submitProfile(Alumni $alumni, array $data, ?UploadedFile $photo = null): Alumni
    {
        if ($photo) {
            app(StoreCompressedImage::class)->delete($alumni->photo);
            $data['photo'] = app(StoreCompressedImage::class)->store($photo, 'alumni/profiles');
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
