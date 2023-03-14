<?php

namespace Modules\Homedy\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Homedy\Console\Commands\SendDataHomedy;

class ScheduleServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->commands([
            SendDataHomedy::class,
        ]);
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
        });
    }

    public function register()
    {
    }
}
