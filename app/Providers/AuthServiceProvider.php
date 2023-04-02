<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Helpers\RolePermissions;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Provide all access to super-user
        Gate::before(function ($user, $ability) {  
            return $user->hasRole(RolePermissions::ROLE_SUPER_ADMIN) ? true : null;  
        });
    }
}
