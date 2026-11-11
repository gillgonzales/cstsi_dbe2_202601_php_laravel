<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('update-user',function (User $user, User $model) {
                // dd([$user,$model]);
                return $user->id === $model->id;
        });

         Gate::define('delete-user',function (User $user, User $model) {
                // dd([$user,$model]);
                return $user->id === $model->id || $user->is_admin;
        });

        Gate::define('superuser',function(User $user){
            return $user->is_admin;
        });

        //Configura limite de requisições para a API
        $this->configureRateLimiting();
         if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }

    //Para limitar requisições na API por usuário ou IP
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
