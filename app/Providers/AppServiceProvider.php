<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;


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
    public function boot()
    {

        if (App::environment(['production'])) {
            URL::forceScheme('https');
        }


        Paginator::useBootstrap();

        Validator::extend('before_closing_time', function ($attribute, $value, $parameters, $validator) {
            $closingTime = request()->input('closing_time');
            return strtotime($value) < strtotime($closingTime);
        });
        Validator::extend('after_opening_time', function ($attribute, $value, $parameters, $validator) {
            $openingTime = request()->input('opening_time');
            return strtotime($value) > strtotime($openingTime);
        });
    }
}
