<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RiceRecommendationService;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RiceRecommendationService::class, function ($app) {
            return new RiceRecommendationService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Disable intl requirement by setting locale
        // This prevents "intl extension required" errors
        // Set to en to use native PHP formatting without intl
        try {
            Number::useLocale('en');
        } catch (\Exception $e) {
            // Silently catch in case of any issues
        }
        
        // Also configure app locale
        config(['app.locale' => 'en']);

        // Allow admin users to access Filament
        Gate::define('viewFilament', function ($user = null) {
            return $user && $user->role === 'admin';
        });
    }
}
