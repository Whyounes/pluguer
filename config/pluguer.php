<?php

use Whyounes\Pluguer\Models\Plugin;

return [
    "plugins_path" => base_path("plugins/"),
    "plugins_db_table" => "plugins",
    "plugins_model" => Plugin::class,
    "register_backend_routes" => true, // Should we register backend routes?
    "backend_base_url" => "backend",
    "backend_routes_path" => __DIR__."/../routes/pluguer.php"
];
