<?php

namespace CSTSI\Dbe2\app\core;

use Dotenv\Dotenv;

class App
{
    public static function init()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
        $dotenv->load();
        require_once __DIR__.'/../../config/routes.php';
        Route::resolve($routes);
    }
}
