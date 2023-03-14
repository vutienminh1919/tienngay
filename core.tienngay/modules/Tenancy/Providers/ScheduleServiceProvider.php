<?php

namespace Modules\Tenancy\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Tenancy\Console\Command\NotificationTenancy;
use Modules\Tenancy\Console\Command\Tenancy;
use Modules\Tenancy\Console\Command\ThanhLyHD;
use Modules\Tenancy\Console\Command\ToiHan;

class ScheduleServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->commands([
           Tenancy::class,
           ToiHan::class,
           NotificationTenancy::class,
           ThanhLyHD::class
        ]);
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command(ToiHan::class)->hourly();
            $schedule->command(NotificationTenancy::class)->hourly();
            $schedule->command(ThanhLyHD::class)->hourly();
        });
    }

    public function register()
    {
    }
}
