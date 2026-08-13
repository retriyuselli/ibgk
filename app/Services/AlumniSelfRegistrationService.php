<?php

namespace App\Services;

use App\Models\Alumni;
use App\Models\AlumniBatch;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

class AlumniSelfRegistrationService
{
    public function __construct(
        private StoreCompressedImage $photoStorage,
    ) {}

    /** @return array<string, mixed> */
    public static function validationRules(): array
    {
        return [
            'alumni_batch_id' => ['required', 'integer', 'exists:alumni_batches,id'],
            'gender' => ['required', 'in:bujang,gadis'],
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
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'photo' => ['nullable', 'image', 'max:'.config('site.profile_photo_max_upload_kb', 10240)],
            'terms' => ['accepted'],
        ];
    }

    public function assertCanRegister(string $email): void
    {
        if (Alumni::query()->where('email', $email)->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Email ini sudah terdaftar sebagai alumni. Silakan masuk ke Dashboard untuk memperbarui profil.',
            ]);
        }

        if (User::query()->where('email', $email)->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Email ini sudah digunakan. Silakan masuk melalui halaman Masuk.',
            ]);
        }
    }

    /** @param  array<string, mixed>  $data */
    public function register(array $data, ?UploadedFile $photo = null): Alumni
    {
        $batch = AlumniBatch::query()->find($data['alumni_batch_id'] ?? null);

        if (! $batch || ! $batch->is_active || (! $batch->isElection() && ! $batch->isFounders())) {
            throw ValidationException::withMessages([
                'alumni_batch_id' => 'Angkatan yang dipilih tidak valid.',
            ]);
        }

        if ($photo) {
            $data['photo'] = $this->photoStorage->store($photo, 'alumni/profiles');
        }

        unset($data['terms'], $data['alumni_batch_id']);

        return Alumni::query()->create([
            ...collect($data)->only([
                'gender',
                'name',
                'photo',
                'university',
                'faculty',
                'study_program',
                'graduation_year',
                'profession',
                'company',
                'city',
                'bio',
                'instagram',
                'linkedin',
                'email',
                'phone',
            ])->all(),
            'alumni_batch_id' => $batch->id,
            'slug' => app(PromoteParticipantToAlumni::class)->uniqueSlug($data['name'], $batch->year),
            'is_public' => false,
            'is_active' => true,
            'profile_submitted_at' => now(),
        ])->load('batch');
    }

    /** @return \Illuminate\Database\Eloquent\Collection<int, AlumniBatch> */
    public function availableBatches()
    {
        return AlumniBatch::orderedForPublicSite();
    }
}
