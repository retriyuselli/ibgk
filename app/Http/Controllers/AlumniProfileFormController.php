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

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'university' => ['nullable', 'string', 'max:255'],
            'faculty' => ['nullable', 'string', 'max:255'],
            'study_program' => ['nullable', 'string', 'max:255'],
            'graduation_year' => ['nullable', 'integer', 'min:1999', 'max:'.(now()->year + 10)],
            'profession' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'photo' => ['nullable', 'image', 'max:5120'],
            'terms' => ['accepted'],
        ]);

        $this->inviteService->submitProfile($alumni, $validated, $request->file('photo'));

        return redirect()
            ->route('alumni.profile.form', $token)
            ->with('alumni_profile_submitted', true);
    }
}
