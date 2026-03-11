<?php

namespace CSTSI\Dbe2\app\controllers;

use CSTSI\Dbe2\app\models\{Produto, ProdutoDAO};

class ProdutoController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new ProdutoDAO();
    }

    public function index()
    {
        $listProdutos = $this->model->read();
        $this->view->load('produtos/index', [
            'produtos' => $listProdutos
        ]);
    }

    public function create(){
        $produto = new Produto(null,'teste','teste',12,123);
        $this->model->create($produto);
        return header("Location: /produtos");
    }

    public function update($id){
        $produto = new Produto($id,'update','update',12,123);
        $this->model->update($produto);
        return header("Location: /produtos");
    }

    public function remove(int $id){
        $this->model->delete($id);
        return header("Location: /produtos");
    }
}
