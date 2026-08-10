<?php

namespace App\Http\Controllers;

use App\Models\OrganizationProfile;
use App\Support\Roles;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = Auth::user();

        return view('pages.dashboard', [
            'profile' => OrganizationProfile::query()->first(),
            'user' => $user,
            'roles' => $user->getRoleNames()->map(fn (string $role): string => Roles::label($role)),
            'canAccessAdmin' => $user->canAccessPanel(Filament::getPanel('admin')),
        ]);
    }
}
