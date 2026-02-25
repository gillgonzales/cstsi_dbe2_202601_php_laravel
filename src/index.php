<?php
require_once '../vendor/autoload.php';

use Dotenv\Dotenv;

echo "<pre>";
echo "Olá Mundo!!!\n";

var_dump(__DIR__);

$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

print_r($_ENV);

echo "\nNome do Banco de Dados: $_ENV[DB_NAME]";
echo "\nServidor do Banco de Dados: $_ENV[DB_HOST]";