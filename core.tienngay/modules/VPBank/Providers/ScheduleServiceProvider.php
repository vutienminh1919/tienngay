<?php

namespace Modules\VPBank\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\VPBank\Console\Commands\DailyReportTransaction;
use Modules\VPBank\Console\Commands\StoreGenCode;
use Modules\VPBank\Console\Commands\CheckTransactionStatus;
use Modules\VPBank\Console\Commands\RerunDailyReportTransaction;
use Modules\VPBank\Console\Commands\PaymentProcess;
use Modules\VPBank\Console\Commands\MasterPaymentProcess;
use Modules\VPBank\Console\Commands\RerunContract;

class ScheduleServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->commands([
            DailyReportTransaction::class,
            StoreGenCode::class,
            CheckTransactionStatus::class,
            RerunDailyReportTransaction::class,
            PaymentProcess::class,
            MasterPaymentProcess::class,
            RerunContract::class
        ]);
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command(DailyReportTransaction::class)->hourly();
            $schedule->command(CheckTransactionStatus::class)->hourly();
            $schedule->command(RerunDailyReportTransaction::class)->hourly();
            $schedule->command(PaymentProcess::class)->hourly();
            
        });
    }

    public function register()
    {
    }
}