<?php

namespace App\Http\Controllers;

use App\Models\OrganizationProfile;
use App\Services\AlumniProfileInviteService;
use App\Services\ResolveAlumniForUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AlumniProfileEditController extends Controller
{
    public function __construct(
        private ResolveAlumniForUser $resolveAlumniForUser,
        private AlumniProfileInviteService $profileService,
    ) {}

    public function edit(): View|RedirectResponse
    {
        $alumni = $this->resolveAlumniForUser->handle(Auth::user());

        if ($alumni === null) {
            return redirect()
                ->route('dashboard')
                ->with('development_access_notice', 'Profil alumni belum terhubung dengan akun Anda. Hubungi pengurus IBGK jika membutuhkan bantuan.');
        }

        return view('pages.alumni-profile-edit', [
            'profile' => OrganizationProfile::query()->first(),
            'alumni' => $alumni,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $alumni = $this->resolveAlumniForUser->handle(Auth::user());

        abort_if($alumni === null, 404);

        $rules = AlumniProfileInviteService::profileValidationRules(requireEmail: true);
        $rules['email'][] = Rule::unique('users', 'email')->ignore(Auth::id());

        $validated = $request->validate($rules);

        $alumni = $this->profileService->submitProfile($alumni, $validated, $request->file('photo'));

        Auth::user()?->forceFill([
            'name' => $alumni->name,
            'email' => $alumni->email,
        ])->save();

        return redirect()
            ->route('alumni.profile.edit')
            ->with('alumni_profile_updated', true);
    }
}
