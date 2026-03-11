<?php

namespace CSTSI\Dbe2\app\views;

class View{

    public static function load(string $page , array | null $data =null) : void {
        $data && extract($data);
        // var_dump(__DIR__);
        require_once __DIR__."/../../public/templates/$page.phtml";
    }
}