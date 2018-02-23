<?php

namespace Whyounes\Pluguer;

use Illuminate\Support\ServiceProvider;

class PluguerServiceProvider extends ServiceProvider
{
    /**
     * @var PluginManager
     */
    protected $pluginManager;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/pluguer.php' => config_path('pluguer.php')
        ], 'config');

        /*$this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');*/

        $this->pluginManager = PluginManager::instance();
        $this->bootPlugins();
        $this->registerBackendRoutes();
    }

    protected function bootPlugins(): void
    {
        $activePlugins = $this->pluginManager->getActivePlugins();
        $activePlugins->each(function (Plugin $plugin) {
            $plugin->boot();
        });
    }

    protected function registerBackendRoutes(): void
    {
        if ((bool)config("plugins.register_backend_routes") === false) {
            return;
        }

        require_once config("plugins.backend_routes_path");
    }

    public function register()
    {
        parent::register();
    }
}