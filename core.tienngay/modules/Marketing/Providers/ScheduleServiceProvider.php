<?php

namespace Modules\Marketing\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Marketing\Console\Command\ForControlReport;
use Modules\Marketing\Console\Command\CloseRequest;

class ScheduleServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->commands([
            ForControlReport::class,
            CloseRequest::class
        ]);
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

        });
    }

    public function register()
    {
    }
}
