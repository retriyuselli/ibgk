<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AssignDefaultUserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    public function __construct(
        private AssignDefaultUserRole $assignDefaultUserRole,
    ) {}

    public function redirect(): RedirectResponse
    {
        if (! $this->googleConfigured()) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Login Google belum dikonfigurasi. Hubungi administrator.']);
        }

        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        if (! $this->googleConfigured()) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Login Google belum dikonfigurasi. Hubungi administrator.']);
        }

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Login Google gagal. Silakan coba lagi.']);
        }

        if (blank($googleUser->getEmail())) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Akun Google tidak memiliki email yang valid.']);
        }

        $user = User::query()->where('google_id', $googleUser->getId())->first()
            ?? User::query()->where('email', $googleUser->getEmail())->first();

        if ($user) {
            $user->fill([
                'google_id' => $googleUser->getId(),
                'name' => $user->name ?: ($googleUser->getName() ?? 'Pengguna Google'),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ])->save();
        } else {
            $user = User::query()->create([
                'name' => $googleUser->getName() ?? 'Pengguna Google',
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'email_verified_at' => now(),
                'password' => null,
            ]);

            $this->assignDefaultUserRole->handle($user);
        }

        Auth::login($user, remember: true);

        session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    private function googleConfigured(): bool
    {
        return filled(config('services.google.client_id'))
            && filled(config('services.google.client_secret'));
    }
}
