<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Team;

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
        View::composer('*', function ($view) {
            $hotels = Team::with('branches.rooms.roomType')->get();
            $view->with('hotels', $hotels);
        });
        View::addNamespace('mail', resource_path('views/vendor/mail'));
    }
}
