<?php

namespace Whyounes\Pluguer\Exceptions;

use Exception;

class PluginNotFoundException extends Exception
{
    protected $message = "Plugin not found.";
}
