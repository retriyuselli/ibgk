<?php

namespace App\Providers;

use App\Models\Election;
use App\Models\OrganizationProfile;
use App\Support\CmsPages;
use BezhanSalleh\FilamentShield\Commands;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $helpers = app_path('helpers.php');

        if (is_file($helpers)) {
            require_once $helpers;
        }

        $this->app->singleton(CmsPages::class);
    }

    public function boot(): void
    {
        FilamentShield::enforcePolicies();
        $this->prohibitShieldCommandsInProduction();

        View::composer(['partials.site.header', 'partials.site.footer', 'layouts.app'], function ($view): void {
            if (! $view->offsetExists('profile')) {
                $view->with('profile', $this->firstOrganizationProfile());
            }
        });

        View::composer([
            'partials.site.header',
            'partials.registration.*',
            'partials.election.*',
            'pages.election-register',
            'pages.election',
        ], function ($view): void {
            if (! $view->offsetExists('activeElection')) {
                $view->with('activeElection', $this->activeElection());
            }
        });

        if (! $this->app->runningInConsole()) {
            View::share('cmsPages', $this->app->make(CmsPages::class));
        }
    }

    private function activeElection(): ?Election
    {
        if (! $this->hasTable('elections')) {
            return null;
        }

        try {
            return Election::query()->where('is_active', true)->latest('year')->first();
        } catch (\Throwable) {
            return null;
        }
    }

    private function firstOrganizationProfile(): ?OrganizationProfile
    {
        if (! $this->hasTable('organization_profiles')) {
            return null;
        }

        try {
            return OrganizationProfile::query()->first();
        } catch (\Throwable) {
            return null;
        }
    }

    private function hasTable(string $table): bool
    {
        try {
            return Schema::hasTable($table);
        } catch (\Throwable) {
            return false;
        }
    }

    private function prohibitShieldCommandsInProduction(): void
    {
        if (! $this->app->isProduction()) {
            return;
        }

        // Diizinkan di production: generate, install, super-admin (deploy & maintenance)
        Commands\SetupCommand::prohibit();
        Commands\SeederCommand::prohibit();
        Commands\PublishCommand::prohibit();
    }
}
