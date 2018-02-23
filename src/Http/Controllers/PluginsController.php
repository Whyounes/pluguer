<?php

namespace Whyounes\Pluguer\Controllers\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Whyounes\Pluguer\Http\Requests\StoreRequest;
use Whyounes\Pluguer\Models\Plugin;
use Whyounes\Pluguer\PluginManager;

class PluginsController extends Controller
{
    /**
     * @var Plugin
     */
    protected $pluginModel;

    public function __construct()
    {
        $this->pluginModel = App::make(config('pluguer.plugins_model'));
    }

    public function index(Request $request)
    {
        $query = $this->pluginModel->newQuery();

        $query->paginate($request->get('per_page', 10));

        return $query->get();
    }

    public function store(StoreRequest $request)
    {
        $pluginFile = $request->file('plugin_file');
        $archive = new \ZipArchive();
        $archive->open($pluginFile->getRealPath());
        $archive->extractTo(base_path($pluginFile->getRealPath())); // extract to the same php tmp/ folder
        $archive->close();

        // @TODO
        // check file exists
        // Check file configuration
        // check version is newer
        // move to plugins folder
        // add to db & activate it
    }

    /**
     * @param Plugin $plugin
     * @return array
     */
    public function activate(Plugin $plugin): array
    {
        if (PluginManager::instance()->activate($plugin)) {
            return [
                "success" => true,
                "message" => "Plugin activated."
            ];
        } else {
            return [
                "success" => false,
                "message" => "Unable to activate the plugin."
            ];
        }
    }

    /**
     * @param Plugin $plugin
     * @return array
     */
    public function deactivate(Plugin $plugin): array
    {
        if (PluginManager::instance()->activate($plugin)) {
            return [
                "success" => true,
                "message" => "Plugin deactivated."
            ];
        } else {
            return [
                "success" => false,
                "message" => "Unable to deactivate the plugin."
            ];
        }
    }

    public function destroy(Plugin $plugin)
    {

    }
}
