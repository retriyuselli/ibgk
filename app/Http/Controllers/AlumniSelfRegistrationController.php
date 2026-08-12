<?php

namespace App\Http\Controllers;

use App\Models\OrganizationProfile;
use App\Services\AlumniSelfRegistrationService;
use App\Services\ProvisionAlumniUserAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AlumniSelfRegistrationController extends Controller
{
    public function __construct(
        private AlumniSelfRegistrationService $registrationService,
        private ProvisionAlumniUserAccount $provisionAlumniUserAccount,
    ) {}

    public function create(): View
    {
        return view('pages.alumni-register', [
            'profile' => OrganizationProfile::query()->first(),
            'batches' => $this->registrationService->availableBatches(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(AlumniSelfRegistrationService::validationRules());

        $this->registrationService->assertCanRegister($validated['email']);

        $alumni = $this->registrationService->register($validated, $request->file('photo'));
        $user = $this->provisionAlumniUserAccount->handle($alumni);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with('alumni_registration_welcome', [
                'name' => $alumni->name,
                'email' => $user->email,
                'temp_password' => config('site.alumni_self_registration_temp_password'),
            ]);
    }
}
