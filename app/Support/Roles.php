<?php

namespace App\Support;

use App\Models\User;

class Roles
{
    public const SUPER_ADMIN = 'super_admin';

    public const PENGUNJUNG = 'pengunjung';

    public const PESERTA = 'peserta';

    public const ANGGOTA = 'anggota';

    public const ADMIN = 'admin';

    /** @return list<string> */
    public static function all(): array
    {
        return [
            self::SUPER_ADMIN,
            self::PENGUNJUNG,
            self::PESERTA,
            self::ANGGOTA,
            self::ADMIN,
        ];
    }

    /** @return array<string, string> */
    public static function labels(): array
    {
        return [
            self::SUPER_ADMIN => 'Super Admin',
            self::PENGUNJUNG => 'Pengunjung',
            self::PESERTA => 'Peserta',
            self::ANGGOTA => 'Anggota',
            self::ADMIN => 'Admin',
        ];
    }

    public static function label(string $role): string
    {
        return self::labels()[$role] ?? str($role)->headline()->toString();
    }

    /** @return list<string> */
    public static function panelAccessRoles(): array
    {
        return [
            self::SUPER_ADMIN,
            self::ADMIN,
        ];
    }

    /** @return list<string> */
    public static function alumniDirectoryRoles(): array
    {
        return [
            self::PENGUNJUNG,
            self::ANGGOTA,
        ];
    }

    public static function canAccessAlumniDirectory(?User $user = null): bool
    {
        if (! config('site.under_development')) {
            return true;
        }

        $user ??= auth()->user();

        if ($user === null) {
            return false;
        }

        if ($user->hasAnyRole(self::panelAccessRoles())) {
            return true;
        }

        return $user->hasAnyRole(self::alumniDirectoryRoles());
    }
}
