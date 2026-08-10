<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\OrganizationProfile;
use App\Services\RegisterElectionParticipant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ElectionRegistrationController extends Controller
{
    public function __construct(
        private RegisterElectionParticipant $registrar,
    ) {}

    public function __invoke(): View
    {
        $election = $this->activeElection();

        return view('pages.election-register', [
            'profile' => OrganizationProfile::query()->first(),
            'election' => $election,
            'registrationOpen' => $this->registrar->isRegistrationOpen($election),
            'requirements' => $election?->requirements ?? collect(),
        ]);
    }

    public function submit(Request $request): RedirectResponse
    {
        $election = $this->activeElection();

        if (! $election || ! $this->registrar->isRegistrationOpen($election)) {
            return redirect()
                ->route('election.register')
                ->with('registration_error', 'Pendaftaran saat ini belum dibuka atau sudah ditutup.');
        }

        $validated = $request->validate([
            'gender' => ['required', 'in:male,female'],
            'full_name' => ['required', 'string', 'max:255'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'university' => ['required', 'string', 'max:255'],
            'faculty' => ['required', 'string', 'max:255'],
            'study_program' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'integer', 'min:1', 'max:14'],
            'city' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:1000'],
            'motto' => ['nullable', 'string', 'max:255'],
            'biography' => ['nullable', 'string', 'max:2000'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'terms' => ['accepted'],
        ]);

        $participant = $this->registrar->handle(
            $election,
            $validated,
            $request->file('photo'),
        );

        return redirect()
            ->route('election.register')
            ->with('registration_success', [
                'name' => $participant->full_name,
                'number' => $participant->registration_number,
            ]);
    }

    private function activeElection(): ?Election
    {
        return Election::query()
            ->where('is_active', true)
            ->with([
                'requirements' => fn ($query) => $query->orderBy('sort_order'),
                'stages' => fn ($query) => $query->orderBy('sort_order'),
            ])
            ->latest('year')
            ->first();
    }
}
