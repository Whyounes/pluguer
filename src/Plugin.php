<?php

namespace Whyounes\Pluguer;

abstract class Plugin
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $version;

    /**
     * Boot the plugin
     * @return void
     */
    public abstract function boot(): void;
}
