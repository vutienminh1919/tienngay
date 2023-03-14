<?php

namespace Modules\Report\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;
use Modules\MongodbCore\Repositories\Interfaces\ReportForm3RepositoryInterface;
use Modules\MongodbCore\Repositories\ReportForm3Repository;
use Modules\MongodbCore\Repositories\Interfaces\ReportForm2RepositoryInterface;
use Modules\MongodbCore\Repositories\ReportForm2Repository;
use Modules\MysqlCore\Repositories\Interfaces\ReportLogTransactionRepositoryInterface;
use Modules\MysqlCore\Repositories\ReportLogTransactionRepository;
use Modules\MongodbCore\Repositories\Interfaces\ReportForm23RepositoryInterface;
use Modules\MongodbCore\Repositories\ReportForm23Repository;

class ReportServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Report';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'report';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        if ( !env("DISABLE_MODULE_REPORT", false) ) {
            $this->registerConfig();
            $this->registerTranslations();
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if ( !env("DISABLE_MODULE_REPORT", false) ) {
            $this->app->register(RouteServiceProvider::class);
            $this->app->bind(ReportForm3RepositoryInterface::class, ReportForm3Repository::class);
            $this->app->bind(ReportForm2RepositoryInterface::class, ReportForm2Repository::class);
            $this->app->bind(ReportLogTransactionRepositoryInterface::class, ReportLogTransactionRepository::class);
            $this->app->bind(ReportForm23RepositoryInterface::class, ReportForm23Repository::class);
        }
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            $this->module_path('Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            $this->module_path('Config/config.php'), $this->moduleNameLower
        );
        // Merge config app
        $config = $this->app['config']->get('app', []);
        $this->app['config']->set('app', $this->mergeConfig($config, require $this->module_path('Config/app.php')));
        // Merge config logging
        $config = $this->app['config']->get('logging', []);
        $this->app['config']->set('logging', $this->mergeConfig($config, require $this->module_path('Config/logging.php')));
    }

    /**
     * Merges the configs together and takes multi-dimensional arrays into account.
     *
     * @param  array  $original
     * @param  array  $merging
     * @return array
     */
    protected function mergeConfig(array $original, array $merging)
    {
        $array = array_merge($original, $merging);

        foreach ($original as $key => $value) {
            if (! is_array($value)) {
                continue;
            }

            if (! Arr::exists($merging, $key)) {
                continue;
            }

            if (is_numeric($key)) {
                continue;
            }

            $array[$key] = $this->mergeConfig($value, $merging[$key]);
        }

        return $array;
    }

    private function module_path($path) {
        return __DIR__.'/../'. $path;
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom($this->module_path('Resources/lang'), $this->moduleName);
        }
    }

}
