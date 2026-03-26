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

    public function show(int $id)
    {
        try{
            $produto = $this->model->read($id);
            $this->view->load('produtos/show', compact('produto'));
        }catch(Exception $error){
            error_log("CONTROLLER: Erro show param $id.\n".print_r($error,true));
            $this->view->pageNotFound();
        }
    }

    public function create(){
        $this->view->load('produtos/create');
    }

    public function store(){
        try{
			$novoProduto = new Produto(null,
				$_POST['nome'],
				$_POST['descricao'],
				$_POST['qtd_estoque'],
				$_POST['preco']
			);

			$novoProduto->importado = isset($_POST['importado']);

			if ($this->model->create($novoProduto)) {
				 return header("Location: /produtos");
			} else {
				$msg = 'Erro ao cadastrar produto!';
				throw new Exception($msg);
			}
		} catch (Exception $error) {
			var_dump([
                $error->getMessage(),
                $error->getTrace(),
            ]);
            die;
		}
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
