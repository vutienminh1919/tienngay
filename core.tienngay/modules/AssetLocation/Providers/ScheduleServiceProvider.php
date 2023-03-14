<?php


namespace Modules\AssetLocation\Providers;


use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Modules\AssetLocation\Console\Command\CronAlarmCheckInAddressCustomer;
use Modules\AssetLocation\Console\Command\CronAuthVset;
use Modules\AssetLocation\Console\Command\CronGetLocationDevice;
use Modules\AssetLocation\Console\Command\CronReportWarehouse;

class ScheduleServiceProvider extends ServiceProvider
{
    public function boot()
    {

        $this->commands([
            CronAuthVset::class,
            CronGetLocationDevice::class,
            CronAlarmCheckInAddressCustomer::class,
            CronReportWarehouse::class
        ]);
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

        });
    }
}
