<?php

namespace Modules\MysqlCore\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;
use Illuminate\Filesystem\Filesystem;

class MysqlCoreServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'MysqlCore';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'mysqlcore';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();
        $this->registerFactories();
        $this->publishMigrations();
        $this->loadMigrationsFrom($this->module_path('Database/Migrations'));
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
        // Merge config database
        $config = $this->app['config']->get('database', []);
        $this->app['config']->set('database', $this->mergeConfig($config, require $this->module_path('Config/database.php')));
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
     * Publish migrations from package
     * command: php artisan vendor:publish --provider="Modules\MysqlCore\Providers\MysqlCoreServiceProvider" --tag="migrations"
     *
     * @return void
     */
    protected function publishMigrations() {
        if ($this->app->runningInConsole()) {
            $argv = \Request::server('argv', null);

            // :$ php artisan migrate:refresh -v
            //
            // gives:
            //
            // $argv = array (
            //      0 => 'artisan',
            //      1 => 'migrate:refresh',
            //      2 => '-v',
            // )  
            if($argv[0] == 'artisan' && \Illuminate\Support\Str::contains(data_get($argv, '3', ''),'--tag=migrations')) {
                // Clean all files 
                $file = new Filesystem;
                $file->cleanDirectory(database_path('migrations/'));
            }

                            
            // Export the migration
            $this->publishes([
                __DIR__ . '/../Database/Migrations/' => database_path('migrations/'),
            ], 'migrations');
        }
    }

    private function module_path($path) {
        return __DIR__.'/../'. $path;
    }
}
