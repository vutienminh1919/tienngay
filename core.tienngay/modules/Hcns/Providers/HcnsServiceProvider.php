<?php

namespace Modules\Hcns\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;
use Modules\MongodbCore\Repositories\Interfaces\HcnsRepositoryInterface;
use Modules\MongodbCore\Repositories\HcnsRepository;

class HcnsServiceProvider extends ServiceProvider
{

    protected $moduleName = 'Hcns';


    protected $moduleNameLower = 'hcns';


    public function boot()
    {
        if ( !env("DISABLE_MODULE_HCNS", false) ) {
            $this->registerConfig();
            $this->registerTranslations();
        }
    }


    public function register()
    {
        if ( !env("DISABLE_MODULE_HCNS", false) ) {
            $this->app->register(RouteServiceProvider::class);
            $this->app->bind(HcnsRepositoryInterface::class, HcnsRepository::class);
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

}
