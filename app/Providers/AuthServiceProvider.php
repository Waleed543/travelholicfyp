<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Profile'=> 'App\Policies\ProfilePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin','App\Gates\UserRole@isAdmin');
        Gate::define('notAdmin','App\Gates\UserRole@notAdmin');
        Gate::define('isStandard','App\Gates\UserRole@isStandard');
        Gate::define('isTourVendor','App\Gates\UserRole@isTourVendor');
    }
}
