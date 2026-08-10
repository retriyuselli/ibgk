<?php

namespace App\Services;

use App\Models\User;
use App\Support\Roles;
use Spatie\Permission\Models\Role;

class AssignDefaultUserRole
{
    public function handle(User $user): void
    {
        if ($user->roles()->exists()) {
            return;
        }

        Role::findOrCreate(Roles::PENGUNJUNG, 'web');

        $user->assignRole(Roles::PENGUNJUNG);
    }
}
