<?php

namespace App\Providers;

use App\Models\Election;
use App\Models\OrganizationProfile;
use App\Support\CmsPages;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CmsPages::class);
    }

    public function boot(): void
    {
        View::composer(['partials.site.header', 'partials.site.footer', 'layouts.app'], function ($view): void {
            if (! $view->offsetExists('profile')) {
                $view->with('profile', OrganizationProfile::query()->first());
            }
        });

        View::share('activeElection', Election::query()->where('is_active', true)->latest('year')->first());

        if (! $this->app->runningInConsole()) {
            View::share('cmsPages', $this->app->make(CmsPages::class));
        }
    }
}
