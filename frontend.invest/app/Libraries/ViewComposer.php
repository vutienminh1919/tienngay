<?php


namespace App\Libraries;


use App\Service\Api;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;


class ViewComposer
{
    public function compose(View $view)
    {
        if (Session::has('user')) {
            $response = Api::post('user/get_action_login', ['id' => Session::get('user')['id']]);
            $action = isset($response['data']) ? $response['data'] : [];
            $is_admin = isset($response['is_admin']) ? $response['is_admin'] : [];
            $view->with('action_global', $action);
            $view->with('is_admin', $is_admin);
        } else {
            $view->with('action_global', []);
            $view->with('is_admin', 0);
        }
    }
}
