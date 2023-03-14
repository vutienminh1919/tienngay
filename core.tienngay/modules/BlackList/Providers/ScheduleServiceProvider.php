<?php

namespace Modules\BlackList\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\BlackList\Console\Command\BlackList;

class ScheduleServiceProvider extends ServiceProvider
{

    public function boot()
    {

        $this->commands([
            BlackList::class
        ]);
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

        });
    }

    public function register()
    {
    }
}
