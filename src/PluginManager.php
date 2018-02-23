<?php

namespace Whyounes\Pluguer;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use TypeError;
use Whyounes\Pluguer\Exceptions\PluginNotFoundException;
use Whyounes\Pluguer\Models\Plugin as PluginModel;

class PluginManager
{
    /**
     * @var null|static
     */
    protected static $instance = null;

    /**
     * @var Collection
     */
    protected $plugins;

    /**
     * @var PluginModel
     */
    protected $pluginModel;

    protected function __construct()
    {
        $this->setPluginModel(config("plugins.plugins_model"));
        $this->loadPlugins();
    }

    /**
     * @param $modelName
     * @throws TypeError
     */
    protected function setPluginModel($modelName): void
    {
        $this->pluginModel = App::make($modelName);

        if (!$this->pluginModel instanceof PluginModel) {
            throw new TypeError("Plugin model must extend `" . PluginModel::class . "`");
        }
    }

    /**
     * Load available plugins
     */
    public function loadPlugins(): void
    {
        $this->plugins = $this->pluginModel->query()->get()->toBase();
        // TODO: Load from filesystem too
    }

    public static function instance(): PluginManager
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * @param $plugin
     * @return bool
     * @throws PluginNotFoundException
     * @throws TypeError
     */
    public function activate($plugin): bool
    {
        return $this->updatePluginStatus($plugin, true);
    }

    /**
     * @param $plugin
     * @param bool $status
     * @return bool
     * @throws PluginNotFoundException
     * @throws TypeError
     */
    private function updatePluginStatus($plugin, bool $status): bool
    {
        /** @var PluginModel $plugin */
        if (!is_string($plugin) && !$plugin instanceof PluginModel) {
            throw new TypeError("Method only accepts a plugin `id` or a `" . PluginModel::class . "` instance.");
        }

        if (is_string($plugin)) {
            $plugin = $this->plugins->where('id', $plugin)->first();
        }

        if (!$plugin) {
            throw new PluginNotFoundException;
        }

        $plugin->is_active = $status;

        return $plugin->save();
    }

    /**
     * @param $plugin
     * @return bool
     * @throws PluginNotFoundException
     * @throws TypeError
     */
    public function deactivate($plugin): bool
    {
        return $this->updatePluginStatus($plugin, false);
    }

    /**
     * Get all the plugins
     */
    public function getPlugins(): Collection
    {
        return $this->plugins;
    }

    /**
     * Get only active plugins the plugins
     */
    public function getActivePlugins(): Collection
    {
        return $this->plugins->where('is_active', true);
    }

    protected function __clone()
    {
    }
}
