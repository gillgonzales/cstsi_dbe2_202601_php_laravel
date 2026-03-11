<?php

namespace CSTSI\Dbe2\app\controllers;

use CSTSI\Dbe2\app\models\{Produto, ProdutoDAO};
use Exception;

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
        // if(count($_POST)){
        //      $nome = isset($_POST['nome'])?$_POST['nome']:null;

        //      if(!$nome)
        //         throw new Exception('Preencha todos os campos!!!');
        //      $produto = new Produto(null,'teste','teste',12,123);         
        // }

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
