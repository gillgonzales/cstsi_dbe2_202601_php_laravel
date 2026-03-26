<?php

namespace CSTSI\Dbe2\app\core;

use CSTSI\Dbe2\app\traits\Env;

class App
{
    use Env;

    public static function init()
    {
        self::load(__DIR__ . "/../../../");
        require_once __DIR__.'/../../config/routes.php';
        Route::resolve($routes);
    }
}
