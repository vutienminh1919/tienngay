<?php

namespace Modules\ViewCpanel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;
use Illuminate\Routing\Router;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface;
use Modules\MongodbCore\Repositories\Interfaces\TradeAdjustmentRepositoryInterface;
use Modules\MongodbCore\Repositories\Interfaces\TradeInventoryReportRepositoryInterface;
use Modules\MongodbCore\Repositories\Interfaces\TradeStorageRepositoryInterface;
use Modules\MongodbCore\Repositories\Interfaces\TransferRepositoryInterface;
use Modules\MongodbCore\Repositories\RoleRepository;
use Modules\MongodbCore\Repositories\TradeAdjustmentRepository;
use Modules\MongodbCore\Repositories\TradeInventoryReportRepository;
use Modules\MongodbCore\Repositories\TradeStorageRepository;
use Modules\MongodbCore\Repositories\TransferRepository;
use Modules\ViewCpanel\Http\Middleware\TokenIsValid;
use Modules\MysqlCore\Repositories\Interfaces\MoMoAppRepositoryInterface;
use Modules\MysqlCore\Repositories\MoMoAppRepository;
use Modules\MysqlCore\Repositories\Interfaces\ReconciliationRepositoryInterface;
use Modules\MysqlCore\Repositories\ReconciliationRepository;
use Modules\MysqlCore\Repositories\Interfaces\VPBankTransactionRepositoryInterface;
use Modules\MysqlCore\Repositories\VPBankTransactionRepository;
use Modules\MongodbCore\Repositories\Interfaces\UserCpanelRepositoryInterface;
use Modules\MongodbCore\Repositories\UserCpanelRepository;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface;
use Modules\MongodbCore\Repositories\StoreRepository;
use Modules\MongodbCore\Repositories\Interfaces\ReportForm3RepositoryInterface;
use Modules\MongodbCore\Repositories\ReportForm3Repository;
use Modules\MongodbCore\Repositories\Interfaces\KsnbRepositoryInterface;
use Modules\MongodbCore\Repositories\KsnbRepository;
use Modules\MongodbCore\Repositories\KsnbCodeErrorsRepositoryInterface;
use Modules\MongodbCore\Repositories\KsnbCodeErrorsRepository;
use Modules\MongodbCore\Repositories\Interfaces\PtiBHTNRepositoryInterface;
use Modules\MongodbCore\Repositories\PtiBHTNRepository;
use Modules\MongodbCore\Repositories\HcnsRepository;
use Modules\MongodbCore\Repositories\Interfaces\HcnsRepositoryInterface;
use Modules\MongodbCore\Repositories\Interfaces\ReportForm2RepositoryInterface;
use Modules\MongodbCore\Repositories\ReportForm2Repository;
use Modules\MysqlCore\Repositories\Interfaces\MistakenVpbankTransactionRepositoryInterface;
use Modules\MysqlCore\Repositories\MistakenVpbankTransactionRepository;
use Modules\MongodbCore\Repositories\HeyuHandoverRepository;
use Modules\MongodbCore\Repositories\Interfaces\HeyuHandoverRepositoryInterface;
use Modules\MongodbCore\Repositories\Interfaces\MacomRepositoryInterface;
use Modules\MongodbCore\Repositories\MacomRepository;
use Modules\MongodbCore\Repositories\AreaRepository;
use Modules\MongodbCore\Repositories\Interfaces\AreaRepositoryInterface;
use Modules\MongodbCore\Repositories\Interfaces\HistoryMacomRepositoryInterface;
use Modules\MongodbCore\Repositories\HistoryMacomRepository;
use Modules\MongodbCore\Repositories\Interfaces\PaymentHolidayRepositoryInterface;
use Modules\MongodbCore\Repositories\PaymentHolidayRepository;
use Modules\MongodbCore\Repositories\Interfaces\DeliveryBillRepositoryInterface;
use Modules\MongodbCore\Repositories\DeliveryBillRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeItemRepositoryInterface;
use Modules\MongodbCore\Repositories\TradeItemRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeTransferRepositoryInterface;
use Modules\MongodbCore\Repositories\TradeTransferRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeBudgetEstimatesRepositoryInterface;
use Modules\MongodbCore\Repositories\TradeBudgetEstimatesRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeHistoryRepositoryInterface;
use Modules\MongodbCore\Repositories\TradeHistoryRepository;
use Modules\MongodbCore\Repositories\Interfaces\TradeOrderRepositoryInterface;
use Modules\MongodbCore\Repositories\TradeOrderRepository;
use Modules\MongodbCore\Repositories\Interfaces\ReportForm23RepositoryInterface;
use Modules\MongodbCore\Repositories\ReportForm23Repository;

class ViewCpanelServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'ViewCpanel';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'viewcpanel';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        if ( !env("DISABLE_MODULE_VIEW_CPANEL", false) ) {
            $this->registerConfig();
            $this->registerFactories();
            $this->registerViews();
            $this->registerAssets();
            $this->registerTranslations();
            $this->loadMigrationsFrom($this->module_path('Database/Migrations'));
            $router = $this->app->make(Router::class);
            $router->aliasMiddleware('tokenIsValid', TokenIsValid::class);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if ( !env("DISABLE_MODULE_VIEW_CPANEL", false) ) {
            $this->app->register(RouteServiceProvider::class);
            $this->app->bind(MoMoAppRepositoryInterface::class, MoMoAppRepository::class);
            $this->app->bind(ReconciliationRepositoryInterface::class, ReconciliationRepository::class);
            $this->app->bind(VPBankTransactionRepositoryInterface::class, VPBankTransactionRepository::class);
            $this->app->bind(UserCpanelRepositoryInterface::class, UserCpanelRepository::class);
            $this->app->bind(StoreRepositoryInterface::class, StoreRepository::class);
            $this->app->bind(ReportForm3RepositoryInterface::class, ReportForm3Repository::class);
            $this->app->bind(ReportForm23RepositoryInterface::class, ReportForm23Repository::class);
            $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
            $this->app->bind(KsnbRepositoryInterface::class, KsnbRepository::class);
            $this->app->bind(KsnbCodeErrorsRepositoryInterface::class, KsnbCodeErrorsRepository::class);
            $this->app->bind(PtiBHTNRepositoryInterface::class, PtiBHTNRepository::class);
            $this->app->bind(HcnsRepositoryInterface::class, HcnsRepository::class);
            $this->app->bind(ReportForm2RepositoryInterface::class, ReportForm2Repository::class);
            $this->app->bind(MistakenVpbankTransactionRepositoryInterface::class, MistakenVpbankTransactionRepository::class);
            $this->app->bind(HeyuHandoverRepositoryInterface::class, HeyuHandoverRepository::class);
            $this->app->bind(MacomRepositoryInterface::class, MacomRepository::class);
            $this->app->bind(AreaRepositoryInterface::class, AreaRepository::class);
            $this->app->bind(HistoryMacomRepositoryInterface::class, HistoryMacomRepository::class);
            $this->app->bind(PaymentHolidayRepositoryInterface::class, PaymentHolidayRepository::class);
            $this->app->bind(DeliveryBillRepositoryInterface::class, DeliveryBillRepository::class);
            $this->app->bind(TradeItemRepositoryInterface::class, TradeItemRepository::class);
            $this->app->bind(TransferRepositoryInterface::class, TransferRepository::class);
            $this->app->bind(TradeBudgetEstimatesRepositoryInterface::class, TradeBudgetEstimatesRepository::class);
            $this->app->bind(TradeHistoryRepositoryInterface::class, TradeHistoryRepository::class);
            $this->app->bind(TradeOrderRepositoryInterface::class, TradeOrderRepository::class);
            $this->app->bind(TradeInventoryReportRepositoryInterface::class, TradeInventoryReportRepository::class);
            $this->app->bind(TradeStorageRepositoryInterface::class, TradeStorageRepository::class);
            $this->app->bind(TradeAdjustmentRepositoryInterface::class, TradeAdjustmentRepository::class);
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

        $this->app['config']->set('domains', require $this->module_path('Config/domains.php'));

        $this->app['config']->set('routes', require $this->module_path('Config/routes.php'));

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

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load($this->module_path('Database/factories'));
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

    public function registerAssets()
    {
        $viewPath = public_path($this->moduleNameLower);

        $sourcePath = $this->module_path('Resources/assets');

        $this->publishes([
            $sourcePath => $viewPath
        ], "assets");
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
