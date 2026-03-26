<?php

namespace CSTSI\Dbe2\app\traits;

use Dotenv\Dotenv;
use Exception;

trait Env
{

    public static function load(string $envPath = "./"): void
    {
        $dotenv = Dotenv::createImmutable($envPath);
        $dotenv->load();
        if (!count($_ENV))
            throw new Exception("Erro ao carregar variáveis de ambiente!");
        error_log("\nENV Criado: " . count($_ENV) . " vars");
        error_log("ENV:\n" . print_r($_ENV, TRUE));
    }
}
