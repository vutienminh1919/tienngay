<?php

namespace Modules\Mailer\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Mailer\Console\Commands\CheckServerAlive;
use Modules\Mailer\Console\Commands\SendMail;
use Modules\Mailer\Console\Commands\ObserveApprovedTransaction;

class ScheduleServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->commands([
            CheckServerAlive::class,
            SendMail::class,
            ObserveApprovedTransaction::class
        ]);
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
        });
    }

    public function register()
    {
    }
}