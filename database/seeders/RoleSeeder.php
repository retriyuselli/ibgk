<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (Roles::all() as $role) {
            Role::findOrCreate($role, 'web');
        }

        $legacyPanelUserRole = Role::query()->where('name', 'panel_user')->first();

        if ($legacyPanelUserRole) {
            User::role('panel_user')->get()->each(function (User $user) use ($legacyPanelUserRole): void {
                $user->removeRole($legacyPanelUserRole);

                if (! $user->roles()->exists()) {
                    $user->assignRole(Roles::ADMIN);
                }
            });

            $legacyPanelUserRole->delete();
        }
    }
}
