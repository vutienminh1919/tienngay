<?php

namespace Modules\PaymentGateway\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;
use Modules\MysqlCore\Repositories\Interfaces\MoMoAppRepositoryInterface;
use Modules\MysqlCore\Repositories\MoMoAppRepository;
use Modules\MysqlCore\Repositories\Interfaces\ReconciliationRepositoryInterface;
use Modules\MysqlCore\Repositories\ReconciliationRepository;
use Modules\MongodbCore\Repositories\Interfaces\ContractRepositoryInterface;
use Modules\MongodbCore\Repositories\ContractRepository;

class PaymentGatewayServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'PaymentGateway';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'paymentgateway';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        if ( !env("DISABLE_MODULE_PAYMENT_GATEWAY", false) ) {
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
        if ( !env("DISABLE_MODULE_PAYMENT_GATEWAY", false) ) {
            $this->registerViews();
            $this->app->register(RouteServiceProvider::class);
            $this->app->bind(MoMoAppRepositoryInterface::class, MoMoAppRepository::class);
            $this->app->bind(ReconciliationRepositoryInterface::class, ReconciliationRepository::class);
            $this->app->bind(ContractRepositoryInterface::class, ContractRepository::class);
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

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = $this->module_path('Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }

}
