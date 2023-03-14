<?php

namespace App\Providers;

use App\Service\Api;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }


//        View::composer('*', function ($view) {
//            if (Session::has('user')) {
//                $response = Api::post('user/get_action_login', ['id' => Session::get('user')['id']]);
//                $action = isset($response['data']) ? $response['data'] : [];
//                $is_admin = isset($response['is_admin']) ? $response['is_admin'] : [];
//                $view->with('action_global', $action);
//                $view->with('is_admin', $is_admin);
//            } else {
//                $view->with('action_global', []);
//                $view->with('is_admin', []);
//            }
//        });

    }
}
