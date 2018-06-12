<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        Gate::define('create-value', function ($user, $variable) {
            return $user->isAutor;
        });
        
        Gate::define('review-value', function ($user, $value) {
            return $user->isRevisor;
        });
        
         Gate::define('edit-own', function ($user, $value) {
            return $user->id==$value->user_id;
        });
        
    }

}
