<?php

namespace CSTSI\Dbe2\app\controllers;

class HomeController extends Controller {

    public function index()
    {
       $this->view->load('home');
    }
}