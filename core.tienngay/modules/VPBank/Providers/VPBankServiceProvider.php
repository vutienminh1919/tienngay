<?php

namespace Modules\VPBank\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;
use Modules\MysqlCore\Repositories\Interfaces\VPBankTransactionRepositoryInterface;
use Modules\MysqlCore\Repositories\VPBankTransactionRepository;
use Modules\MongodbCore\Repositories\Interfaces\ContractRepositoryInterface;
use Modules\MongodbCore\Repositories\ContractRepository;
use Modules\MongodbCore\Repositories\Interfaces\TemporaryPlanRepositoryInterface;
use Modules\MongodbCore\Repositories\TemporaryPlanRepository;
use Modules\MysqlCore\Repositories\Interfaces\CustomerContractRepositoryInterface;
use Modules\MysqlCore\Repositories\CustomerContractRepository;
use Modules\MysqlCore\Repositories\Interfaces\VPBankVANRepositoryInterface;
use Modules\MysqlCore\Repositories\VPBankVANRepository;
use Modules\MongodbCore\Repositories\Interfaces\RoleRepositoryInterface;
use Modules\MongodbCore\Repositories\RoleRepository;
use Modules\MysqlCore\Repositories\Interfaces\CustomerRepositoryInterface;
use Modules\MysqlCore\Repositories\CustomerRepository;
use Modules\MongodbCore\Repositories\Interfaces\StoreRepositoryInterface;
use Modules\MongodbCore\Repositories\StoreRepository;
use Modules\MongodbCore\Repositories\Interfaces\TransactionRepositoryInterface;
use Modules\MongodbCore\Repositories\TransactionRepository;
use Modules\MysqlCore\Repositories\Interfaces\MistakenVpbankTransactionRepositoryInterface;
use Modules\MysqlCore\Repositories\MistakenVpbankTransactionRepository;

class VPBankServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'VPBank';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'vpbank';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        if ( !env("DISABLE_MODULE_VPBANK", false) ) {
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
        if ( !env("DISABLE_MODULE_VPBANK", false) ) {
            $this->app->register(RouteServiceProvider::class);
            $this->app->bind(VPBankTransactionRepositoryInterface::class, VPBankTransactionRepository::class);
            $this->app->bind(ContractRepositoryInterface::class, ContractRepository::class);
            $this->app->bind(TemporaryPlanRepositoryInterface::class, TemporaryPlanRepository::class);
            $this->app->bind(CustomerContractRepositoryInterface::class, CustomerContractRepository::class);
            $this->app->bind(VPBankVANRepositoryInterface::class, VPBankVANRepository::class);
            $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
            $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
            $this->app->bind(StoreRepositoryInterface::class, StoreRepository::class);
            $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
            $this->app->bind(MistakenVpbankTransactionRepositoryInterface::class, MistakenVpbankTransactionRepository::class);
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
