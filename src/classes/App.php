<?php

namespace CSTSI\Dbe2\classes;

use Dotenv\Dotenv;

class App
{

    public static function loadEnv()
    {
        //TODO: Carregar as variáveis de ambiente aqui
        echo "\nCarregar ENV";
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        print_r($_ENV);

        echo "\nNome do Banco de Dados: $_ENV[DB_NAME]";
        echo "\nServidor do Banco de Dados: $_ENV[DB_HOST]";
    }
}
