<?php

namespace Modules\Tenancy\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;
use Modules\MongodbCore\Repositories\Interfaces\UserCpanelRepositoryInterface;
use Modules\MongodbCore\Repositories\UserCpanelRepository;
use Modules\Tenancy\Http\Middleware\Auth;
use Modules\Tenancy\Http\Middleware\Tenancy_ke_toan_valid;
use Modules\Tenancy\Http\Middleware\Tenancy_ptmb_valid;

class TenancyServiceProvider extends ServiceProvider
{

    protected $moduleName = 'Tenancy';


    protected $moduleNameLower = 'tenancy';


    public function boot()
    {
        if ( !env("DISABLE_MODULE_TENANCY", false) ) {
            $this->registerConfig();
            $this->registerTranslations();
            $this->registerViews();
            $router = $this->app->make(Router::class);
            $router->aliasMiddleware('check_ke_toan', Tenancy_ke_toan_valid::class);
            $router->aliasMiddleware('check_phat_trien_mat_bang', Tenancy_ptmb_valid::class);
            $router->aliasMiddleware('auth_tenancy', Auth::class);
        }
    }


    public function register()
    {
        if ( !env("DISABLE_MODULE_TENANCY", false) ) {
            $this->app->register(RouteServiceProvider::class);
            $this->app->bind(UserCpanelRepositoryInterface::class, UserCpanelRepository::class);
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
