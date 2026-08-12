<?php

namespace App\Services;

use App\Models\Alumni;
use App\Models\User;

class ProvisionAlumniUserAccount
{
    public function __construct(
        private AssignDefaultUserRole $assignDefaultUserRole,
    ) {}

    public function handle(Alumni $alumni): User
    {
        $user = User::query()->create([
            'name' => $alumni->name,
            'email' => $alumni->email,
            'password' => config('site.alumni_self_registration_temp_password'),
        ]);

        $this->assignDefaultUserRole->handle($user);

        $alumni->forceFill(['user_id' => $user->id])->save();

        return $user;
    }
}
