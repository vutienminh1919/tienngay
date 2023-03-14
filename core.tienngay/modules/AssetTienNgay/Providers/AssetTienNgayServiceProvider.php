<?php

namespace Modules\AssetTienNgay\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Arr;
use Modules\AssetTienNgay\Http\Middleware\Auth;
use Modules\AssetTienNgay\Http\Middleware\AuthApp;
use Modules\AssetTienNgay\Http\Middleware\CheckDoc;

class AssetTienNgayServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'AssetTienNgay';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'assettienngay';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();
        $this->registerTranslations();
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('checkDoc', CheckDoc::class);
        $router->aliasMiddleware('auth_app', AuthApp::class);
        $router->aliasMiddleware('auth_asset', Auth::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
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
        // Merge config database
        $config = $this->app['config']->get('database', []);
        $this->app['config']->set('database', $this->mergeConfig($config, require $this->module_path('Config/database.php')));
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
