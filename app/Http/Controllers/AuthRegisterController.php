<?php

namespace App\Http\Controllers;

use App\Models\OrganizationProfile;
use App\Models\User;
use App\Services\AssignDefaultUserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthRegisterController extends Controller
{
    public function __construct(
        private AssignDefaultUserRole $assignDefaultUserRole,
    ) {}
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->intended(route('dashboard'));
        }

        return view('pages.register', [
            'profile' => OrganizationProfile::query()->first(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'terms' => ['accepted'],
        ]);

        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        $this->assignDefaultUserRole->handle($user);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->intended(route('dashboard'))
            ->with('registration_success', 'Akun berhasil dibuat. Selamat datang, '.$user->name.'!');
    }
}
