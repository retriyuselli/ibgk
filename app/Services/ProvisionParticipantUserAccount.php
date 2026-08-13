<?php

namespace App\Services;

use App\Models\Participant;
use App\Models\User;
use App\Support\Roles;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class ProvisionParticipantUserAccount
{
    public function handle(Participant $participant, string $password): User
    {
        if (blank($participant->email)) {
            throw ValidationException::withMessages([
                'email' => 'Email wajib diisi untuk membuat akun Dashboard Peserta.',
            ]);
        }

        if (User::query()->where('email', $participant->email)->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Email ini sudah digunakan. Silakan masuk melalui halaman Masuk.',
            ]);
        }

        $user = User::query()->create([
            'name' => $participant->full_name,
            'email' => $participant->email,
            'password' => $password,
        ]);

        Role::findOrCreate(Roles::PESERTA, 'web');
        $user->assignRole(Roles::PESERTA);

        $participant->forceFill(['user_id' => $user->id])->save();

        return $user;
    }
}
