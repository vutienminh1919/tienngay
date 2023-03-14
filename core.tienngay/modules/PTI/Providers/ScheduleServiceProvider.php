<?php

namespace Modules\PTI\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\PTI\Console\Commands\RunOrderBhtn;
use Modules\PTI\Console\Commands\ReRunOrderBhtn;

class ScheduleServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->commands([
            RunOrderBhtn::class,
            ReRunOrderBhtn::class,
        ]);
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
        });
    }

    public function register()
    {
    }
}