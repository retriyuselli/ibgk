<?php

namespace App\Http\Middleware;

use App\Support\Roles;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDevelopmentAccess
{
    /** @var list<string> */
    private array $exemptRoutes = [
        'favicon',
        'favicon.apple',
        'home',
        'login',
        'login.store',
        'auth.google',
        'auth.google.callback',
        'alumni.profile.form',
        'alumni.profile.form.submit',
        'alumni.register',
        'alumni.register.store',
        'election',
        'election.register',
        'election.register.submit',
    ];

    /** @var list<string> */
    private array $restrictedUserRoutes = [
        'dashboard',
        'alumni.profile.edit',
        'alumni.profile.update',
        'logout',
    ];

    /** @var list<string> */
    private array $alumniDirectoryRoutes = [
        'alumni',
        'alumni.show',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (! config('site.under_development')) {
            return $next($request);
        }

        if ($request->routeIs(...$this->exemptRoutes)) {
            return $next($request);
        }

        $user = $request->user();

        if ($user === null) {
            return redirect()->route('home');
        }

        if ($user->hasAnyRole(Roles::panelAccessRoles())) {
            return $next($request);
        }

        if ($request->routeIs(...$this->alumniDirectoryRoutes)) {
            if ($user->hasAnyRole(Roles::alumniDirectoryRoles())) {
                return $next($request);
            }

            return redirect()
                ->route('dashboard')
                ->with('development_access_notice', 'Halaman Alumni hanya dapat diakses oleh akun Pengunjung dan Anggota.');
        }

        if ($request->routeIs(...$this->restrictedUserRoutes)) {
            return $next($request);
        }

        $message = $user->hasAnyRole(Roles::alumniDirectoryRoles())
            ? 'Saat ini website masih dalam proses perbaikan. Anda hanya dapat mengakses Dashboard dan halaman Alumni.'
            : 'Saat ini website masih dalam proses perbaikan. Anda hanya dapat mengakses Dashboard.';

        return redirect()
            ->route('dashboard')
            ->with('development_access_notice', $message);
    }
}
