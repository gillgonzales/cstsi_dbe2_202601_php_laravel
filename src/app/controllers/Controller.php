<?php
namespace CSTSI\Dbe2\app\controllers;

use CSTSI\Dbe2\app\interfaces\iDAO;
use CSTSI\Dbe2\app\traits\ValidateRequest;
use CSTSI\Dbe2\app\views\View;

abstract class Controller{

	use ValidateRequest;

	protected View $view;
	protected iDAO $model;

	public abstract function index();

	public function __construct()
	{
		session_start();
		header("Content-Type:text/html;charset=UTF8");
		$this->view = new View();
	}

	public function getView(){
		return $this->view;
	}
}