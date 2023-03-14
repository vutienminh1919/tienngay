<?php

namespace Modules\CtvTienNgay\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\CtvTienNgay\Console\Command\CronUpdateStatusLead;
use Modules\CtvTienNgay\Console\Command\Ekyc;

class ScheduleServiceProvider extends ServiceProvider
{

    public function boot()
    {

        $this->commands([
            Ekyc::class,
            CronUpdateStatusLead::class
        ]);
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

        });
    }

    public function register()
    {
    }
}
