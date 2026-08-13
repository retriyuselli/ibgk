<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\OrganizationProfile;
use App\Models\Participant;
use App\Services\ProvisionParticipantUserAccount;
use App\Services\RegisterElectionParticipant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ElectionRegistrationController extends Controller
{
    public function __construct(
        private RegisterElectionParticipant $registrar,
        private ProvisionParticipantUserAccount $provisionParticipantUserAccount,
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

        $photoMaxKb = (int) config('site.profile_photo_max_upload_kb', 10240);

        $validated = $request->validate([
            'gender' => ['required', 'in:male,female'],
            'religion' => ['required', 'in:'.implode(',', array_keys(Participant::religionOptions()))],
            'full_name' => ['required', 'string', 'max:255'],
            'nickname' => ['required', 'string', 'max:255'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'university' => ['required', 'string', 'max:255'],
            'faculty' => ['required', 'string', 'max:255'],
            'study_program' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'integer', 'min:1', 'max:14'],
            'gpa' => ['required', 'numeric', 'min:0', 'max:4'],
            'height_cm' => ['required', 'integer', 'min:100', 'max:250'],
            'weight_kg' => ['required', 'numeric', 'min:30', 'max:200'],
            'medical_history' => ['nullable', 'string', 'max:2000'],
            'city' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
                Rule::unique('participants', 'email')->where('election_id', $election->id),
            ],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => ['required', 'string', 'max:30'],
            'emergency_phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:1000'],
            'motto' => ['nullable', 'string', 'max:255'],
            'biography' => ['nullable', 'string', 'max:2000'],
            'instagram' => ['required', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:255'],
            'hobbies' => ['required', 'string', 'max:2000'],
            'talents' => ['required', 'string', 'max:2000'],
            'parent_name' => ['required', 'string', 'max:255'],
            'parent_occupation' => ['required', 'string', 'max:255'],
            'parent_address' => ['required', 'string', 'max:1000'],
            'motivation' => ['required', 'string', 'max:3000'],
            'ibgk_opinion' => ['required', 'string', 'max:3000'],
            'achievements' => ['required', 'string', 'max:3000'],
            'photo' => ['required', 'image', 'max:'.$photoMaxKb],
            'photo_full_body' => ['required', 'image', 'max:'.$photoMaxKb],
            'terms' => ['accepted'],
        ], [
            'email.unique' => 'Email ini sudah digunakan. Gunakan email lain atau masuk melalui halaman Masuk.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai.',
        ]);

        $participant = DB::transaction(function () use ($election, $validated, $request) {
            $participant = $this->registrar->handle(
                $election,
                $validated,
                $request->file('photo'),
                $request->file('photo_full_body'),
            );

            $user = $this->provisionParticipantUserAccount->handle($participant, $validated['password']);

            Auth::login($user);
            $request->session()->regenerate();

            return $participant;
        });

        return redirect()
            ->route('dashboard')
            ->with('participant_registration_welcome', [
                'name' => $participant->full_name,
                'email' => $participant->email,
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
