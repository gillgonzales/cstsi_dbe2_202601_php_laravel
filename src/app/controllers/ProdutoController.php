<?php

namespace CSTSI\Dbe2\app\controllers;

use CSTSI\Dbe2\app\models\Produto;

class ProdutoController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new Produto();
    }

    public function index()
    {
        $listProdutos = $this->model->getAll();
        $this->view->load('produtos/index', [
            'produtos' => $listProdutos
        ]);
    }
}
