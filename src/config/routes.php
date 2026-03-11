<?php

use CSTSI\Dbe2\app\controllers\{ProdutoController, HomeController};

$routes = [
    '/' => HomeController::class,
    'produtos' => ProdutoController::class
];
