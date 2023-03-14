<?php

namespace App\Providers;

use App\Service\Api;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('checkAction', function ($check) {
            if ($check == true) {
                return true;
            }
            return false;
        });


//        Gate::define('paypal', function ($user) {
//            $response = Api::post('user/get_action_user', ['id' => $user['id'], 'uri' => 'pay/detail_paypal']);
//            $check = isset($response['check']) ? $response['check'] : false;
//            if ($check == true) {
//                return true;
//            }
//            return false;
//        });

    }
}
