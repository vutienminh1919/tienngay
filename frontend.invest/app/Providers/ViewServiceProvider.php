<?php


namespace App\Providers;


use App\Libraries\ViewComposer;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    const VIEWS = [
        'contract.*',
        'user.*',
        'pay.list',
        'pay.list_uq',
        'action.*',
        'interest.list',
        'investor.*',
        'menu.*',
        'transaction.*',
        'investment.list',
        'layout.header',
        'import.*',
        'config.*',
        'dashboard.*',
        'commission.*',
    ];

    public function register()
    {
        //
    }

    public function boot()
    {
//        View::composer('*', ViewComposer::class);
        View::composer(self::VIEWS, ViewComposer::class);

    }
}
