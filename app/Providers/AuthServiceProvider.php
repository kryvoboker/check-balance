<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Services\AuthorizationService;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->app->singleton(AuthorizationService::class, function ($app) {
            return new AuthorizationService();
        });
    }
}
