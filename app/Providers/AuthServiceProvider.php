<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Subscription;
use App\Models\User;
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



        Gate::define('see_published_legalacts', function (User $user) {
            return $user->isAdmin;
        });

        Gate::define('see_inactive_types', function (User $user) {
            return $user->isAdmin;
        });

        Gate::define('manage_records', function (User $user) {
            return $user->isAdmin;
        });

        Gate::define('update_subscription', function (User $user, Subscription $subscription) {
            return $user->isAdmin || $subscription->user->id == $user->id;
        });
    }
}
