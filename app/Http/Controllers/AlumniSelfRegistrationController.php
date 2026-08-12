<?php

namespace App\Http\Controllers;

use App\Models\OrganizationProfile;
use App\Services\AlumniSelfRegistrationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlumniSelfRegistrationController extends Controller
{
    public function __construct(
        private AlumniSelfRegistrationService $registrationService,
    ) {}

    public function create(): View
    {
        return view('pages.alumni-register', [
            'profile' => OrganizationProfile::query()->first(),
            'batches' => $this->registrationService->availableBatches(),
            'submitted' => session('alumni_registration_success'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(AlumniSelfRegistrationService::validationRules());

        $alumni = $this->registrationService->register($validated, $request->file('photo'));

        return redirect()
            ->route('alumni.register')
            ->with('alumni_registration_success', [
                'name' => $alumni->name,
                'batch' => $alumni->batch?->name,
            ]);
    }
}
