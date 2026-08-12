<?php

namespace App\Http\Controllers;

use App\Models\OrganizationProfile;
use App\Services\ResolveAlumniForUser;
use App\Support\Roles;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private ResolveAlumniForUser $resolveAlumniForUser,
    ) {}

    public function __invoke(): View
    {
        $user = Auth::user();

        return view('pages.dashboard', [
            'profile' => OrganizationProfile::query()->first(),
            'user' => $user,
            'alumni' => $this->resolveAlumniForUser->handle($user),
            'roles' => $user->getRoleNames()->map(fn (string $role): string => Roles::label($role)),
            'canAccessAdmin' => $user->canAccessPanel(Filament::getPanel('admin')),
            'canBrowsePublicSite' => ! config('site.under_development') || $user->canAccessPanel(Filament::getPanel('admin')),
        ]);
    }
}
