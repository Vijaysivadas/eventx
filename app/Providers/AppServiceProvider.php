<?php

namespace App\Providers;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
        //
        Authenticate::redirectUsing(function (Request $request) {
            if ($request->expectsJson()) {
                return null; // Prevent redirect for API requests
            }

            // Get current route and its applied middleware
            $route = Route::current();
            $middleware = $route ? $route->gatherMiddleware() : [];

            // Default redirect
            $redirectTo = route('user.login');

            // Check for specific guards
            if (in_array('auth:admin', $middleware)) {
                $redirectTo = route('admin.login');
            }

            return $redirectTo;
        });
    }
}
