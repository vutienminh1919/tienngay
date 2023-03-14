<?php

namespace Modules\ApiCpanel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\ApiCpanel\Console\Commands\KTHelper;

class ScheduleServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->commands([
            KTHelper::class,
        ]);
        $this->app->booted(function () {
        });
    }

    public function register()
    {
    }
}
