<?php

namespace Modules\PaymentGateway\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\PaymentGateway\Console\Commands\CheckTransactionStatus;
use Modules\PaymentGateway\Console\Commands\SendTransactionReconciliationEmail;
use Modules\PaymentGateway\Console\Commands\CheckMomoTransactionInBank;

class ScheduleServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->commands([
            CheckTransactionStatus::class,
            SendTransactionReconciliationEmail::class,
            CheckMomoTransactionInBank::class,
        ]);
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command(CheckTransactionStatus::class)->hourly();
            $schedule->command(SendTransactionReconciliationEmail::class)->everyFiveMinutes();
            $schedule->command(CheckMomoTransactionInBank::class)->dailyAt('8:00');
        });
    }

    public function register()
    {
    }
}