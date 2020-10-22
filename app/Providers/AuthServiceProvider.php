<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Favorite' => 'App\Policies\FavoritePolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Review' => 'App\Policies\ReviewPolicy',
        'App\Cart' => 'App\Policies\CartPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
