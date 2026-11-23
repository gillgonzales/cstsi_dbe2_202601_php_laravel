<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class GatesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('update-user', function (User $user, User $model) {
            // dd([$user,$model]);
            return $user->id === $model->id;
        });

        Gate::define('delete-user', function (User $user, User $model) {
            // dd([$user,$model]);
            return $user->id === $model->id || $user->is_admin;
        });

        Gate::define('superuser', function (User $user) {
            return $user->is_admin;
        });
    }
}
