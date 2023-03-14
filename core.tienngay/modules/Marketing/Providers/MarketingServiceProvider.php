<?php

namespace Modules\Marketing\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;
use Modules\MongodbCore\Repositories\Interfaces\DeliveryBillRepositoryInterface;
use Modules\MongodbCore\Repositories\Interfaces\TradeAdjustmentRepositoryInterface;
use Modules\MongodbCore\Repositories\Interfaces\TradeItemRepositoryInterface;
use Modules\MongodbCore\Repositories\TradeAdjustmentRepository;
use Modules\MongodbCore\Repositories\TradeItemRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeInventoryReportRepositoryInterface;
use Modules\MongodbCore\Repositories\TradeInventoryReportRepository;
use Modules\MongodbCore\Repositories\DeliveryBillRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeItemDetailRepositoryInterface;
use Modules\MongodbCore\Repositories\TradeItemDetailRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeOrderRepositoryInterface;
use Modules\MongodbCore\Repositories\TradeOrderRepository;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface;
use Modules\MongodbCore\Repositories\StoreRepository;
use Modules\MongodbCore\Repositories\TradeStorageRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeStorageRepositoryInterface;
use Modules\MongodbCore\Repositories\Interfaces\AreaRepositoryInterface;
use Modules\MongodbCore\Repositories\AreaRepository;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface;
use Modules\MongodbCore\Repositories\RoleRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeBudgetEstimatesRepositoryInterface;
use Modules\MongodbCore\Repositories\TradeBudgetEstimatesRepository;
use Modules\MongodbCore\Repositories\Interfaces\TransferRepositoryInterface;
use Modules\MongodbCore\Repositories\TransferRepository;
use Modules\MongodbCore\Repositories\TradeHistoryRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeHistoryRepositoryInterface;
use Modules\MongodbCore\Repositories\GroupRoleRepository;



class MarketingServiceProvider extends ServiceProvider
{

    protected $moduleName = 'Marketing';


    protected $moduleNameLower = 'marketing';


    public function boot()
    {
        if ( !env("DISABLE_MODULE_MARKETING", false) ) {
            $this->registerConfig();
            $this->registerTranslations();
            $this->registerViews();
        }
    }


    public function register()
    {
        if ( !env("DISABLE_MODULE_MARKETING", false) ) {
            $this->app->register(RouteServiceProvider::class);
            $this->app->bind(TradeItemRepositoryInterface::class, TradeItemRepository::class);
            $this->app->bind(TradeInventoryReportRepositoryInterface::class, TradeInventoryReportRepository::class);
            $this->app->bind(DeliveryBillRepositoryInterface::class, DeliveryBillRepository::class);
            $this->app->bind(TradeItemDetailRepositoryInterface::class, TradeItemDetailRepository::class);
            $this->app->bind(TradeOrderRepositoryInterface::class, TradeOrderRepository::class);
            $this->app->bind(StoreRepositoryInterface::class, StoreRepository::class);
            $this->app->bind(TradeStorageRepositoryInterface::class, TradeStorageRepository::class);
            $this->app->bind(TradeAdjustmentRepositoryInterface::class, TradeAdjustmentRepository::class);
            $this->app->bind(AreaRepositoryInterface::class, AreaRepository::class);
            $this->app->bind(TradeBudgetEstimatesRepositoryInterface::class, TradeBudgetEstimatesRepository::class);
            $this->app->bind(TransferRepositoryInterface::class, TransferRepository::class);
            $this->app->bind(TradeHistoryRepositoryInterface::class, TradeHistoryRepository::class);
            $this->app->bind(GroupRoleRepository::class);
        }
    }


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
