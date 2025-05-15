<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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

    Gate::define('manage-products', function ($user) {
    return $user->role === 'admin';
});
    Gate::define('manage-orders', function ($user) {
        return $user->role === 'admin';
    });
    Gate::define('manage-category', function ($user) {
        return $user->role === 'admin';
    });
    Gate::define('manage-users', function ($user) {
        return $user->role === 'admin';
    });
    Gate::define('place-order', function ($user) {
    return $user->role === 'customer';
});
    Gate::define('view-orders', function ($user) {
        return $user->role === 'customer';
    });
    Gate::define('view-cart', function ($user) {
        return $user->role === 'customer';
    });
    Gate::define('view-products', function ($user) {
        return $user->role === 'customer';
    });
}
}