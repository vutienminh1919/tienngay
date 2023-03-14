<?php

namespace Modules\ViewCpanel\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\ViewCpanel\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();
        $this->mapPaymentHolidaysRoutes();
        $this->mapTradeRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group($this->module_path('/Routes/web.php'));
    }

    /**
     * Define the "payment_holidays" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapPaymentHolidaysRoutes()
    {
        Route::prefix('cpanel')
            ->middleware('web')
            ->namespace($this->moduleNamespace)
            ->group($this->module_path('/Routes/payment_holidays.php'));
    }

    /**
     * Define the "trade mkt module" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapTradeRoutes()
    {
        Route::prefix('cpanel')
            ->middleware('web')
            ->namespace($this->moduleNamespace)
            ->group($this->module_path('/Routes/trade.php'));
    }

    private function module_path($path) {
        return __DIR__.'/../'. $path;
    }
}
