<?php

namespace Modules\Heyu\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;
use Modules\Heyu\Http\Middleware\Locale;
use Modules\MongodbCore\Repositories\HeyuStoreRepository;
use Modules\MongodbCore\Repositories\Interfaces\HeyuStoreRepositoryInterface;
use Modules\ViewCpanel\Http\Middleware\TokenIsValid;
use Modules\MongodbCore\Repositories\HeyuHandoverRepository;
use Modules\MongodbCore\Repositories\Interfaces\HeyuHandoverRepositoryInterface;

class HeyuServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Heyu';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'heyu';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (!env("DISABLE_MODULE_HEYU", false)) {
            $this->registerConfig();
            $this->registerTranslations();
            $router = $this->app->make(Router::class);
            $router->aliasMiddleware('locale', Locale::class);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if (!env("DISABLE_MODULE_HEYU", false)) {
            $this->app->register(RouteServiceProvider::class);
            $this->app->bind(HeyuHandoverRepositoryInterface::class, HeyuHandoverRepository::class);
            $this->app->bind(HeyuStoreRepositoryInterface::class, HeyuStoreRepository::class);
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
     * @param array $original
     * @param array $merging
     * @return array
     */
    protected function mergeConfig(array $original, array $merging)
    {
        $array = array_merge($original, $merging);

        foreach ($original as $key => $value) {
            if (!is_array($value)) {
                continue;
            }

            if (!Arr::exists($merging, $key)) {
                continue;
            }

            if (is_numeric($key)) {
                continue;
            }

            $array[$key] = $this->mergeConfig($value, $merging[$key]);
        }

        return $array;
    }

    private function module_path($path)
    {
        return __DIR__ . '/../' . $path;
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
