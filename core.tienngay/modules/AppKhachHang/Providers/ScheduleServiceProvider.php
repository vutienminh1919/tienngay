<?php

namespace Modules\AppKhachHang\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\AppKhachHang\Console\Command\AppKhachHang;

class ScheduleServiceProvider extends ServiceProvider
{

    public function boot()
    {

        $this->commands([
            AppKhachHang::class
        ]);
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

        });
    }

    public function register()
    {
    }
}
