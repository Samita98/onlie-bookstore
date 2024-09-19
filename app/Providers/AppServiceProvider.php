<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        //
        Paginator::useBootstrap();
        
        Schema::defaultStringLength(191);
        if (Schema::hasTable('settings')) {
        foreach (\App\Model\Setting::all() as $setting) {
        config(['setting.'.$setting->name => $setting->value]);
            }
        }
    }
}
