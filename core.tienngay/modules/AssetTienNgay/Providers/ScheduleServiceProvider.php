<?php


namespace Modules\AssetTienNgay\Providers;


use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Modules\AssetTienNgay\Console\Command\CronConfirmAsset;

class ScheduleServiceProvider extends ServiceProvider
{
    public function boot()
    {

        $this->commands([
            CronConfirmAsset::class
        ]);
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

        });
    }
}
