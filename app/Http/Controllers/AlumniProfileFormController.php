<?php

namespace App\Http\Controllers;

use App\Models\OrganizationProfile;
use App\Services\AlumniProfileInviteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlumniProfileFormController extends Controller
{
    public function __construct(
        private AlumniProfileInviteService $inviteService,
    ) {}

    public function show(string $token): View
    {
        $alumni = $this->inviteService->findByToken($token);

        abort_unless($this->inviteService->isTokenValid($alumni), 404);

        return view('pages.alumni-profile-form', [
            'profile' => OrganizationProfile::query()->first(),
            'alumni' => $alumni,
            'submitted' => session('alumni_profile_submitted'),
        ]);
    }

    public function submit(Request $request, string $token): RedirectResponse
    {
        $alumni = $this->inviteService->findByToken($token);

        abort_unless($this->inviteService->isTokenValid($alumni), 404);

        $validated = $request->validate(AlumniProfileInviteService::profileValidationRules());

        $this->inviteService->submitProfile($alumni, $validated, $request->file('photo'));

        return redirect()
            ->route('alumni.profile.form', $token)
            ->with('alumni_profile_submitted', true);
    }
}
