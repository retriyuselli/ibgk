<?php

namespace App\Services;

use App\Models\Alumni;
use App\Models\User;

class ResolveAlumniForUser
{
    public function handle(User $user): ?Alumni
    {
        $alumni = Alumni::query()
            ->with('batch')
            ->where('user_id', $user->id)
            ->first();

        if ($alumni) {
            return $alumni;
        }

        $alumni = Alumni::query()
            ->with('batch')
            ->whereNull('user_id')
            ->where('email', $user->email)
            ->latest('id')
            ->first();

        if ($alumni) {
            $alumni->forceFill(['user_id' => $user->id])->save();
        }

        return $alumni;
    }
}
