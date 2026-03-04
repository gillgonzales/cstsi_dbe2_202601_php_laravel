<?php
require_once '../vendor/autoload.php';

use CSTSI\Dbe2\classes\App;

echo "<pre>";
echo "Olá Mundo!!!\n";

var_dump(__DIR__);

App::loadEnv();