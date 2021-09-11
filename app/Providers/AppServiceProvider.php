<?php

namespace App\Providers;

use App\Models\Sales;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        view()->composer(['layouts.navigation'], function ($view) {
            $sales = null;

            if (Auth::user()) {
                $user = Auth::user();
                $sales = Sales::where('user_id', $user->id)->where('payment', null)->get();
            }
            $view->with('sales', $sales);
        });
    }
}
