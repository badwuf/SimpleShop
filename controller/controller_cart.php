<?php
class Controller_cart extends Controller{
	
	private $model;
	
	function __construct(){
		parent::__construct();
		
		$this->model = new Model_cart();
	}
	
	function action_main(){
		echo $this->twig->render('cart.html',array());
	}
	
	function action_add(){
		header("Content-type: application/json;");
		echo $this->model->addItem($_POST['item_id']);
	}
	
	function action_delete(){
		header("Content-type: application/json;");
		echo $this->model->deleteItem($_POST['item_id']);
	}
	
	function action_count(){
		header("Content-type: application/json;");
		echo $this->model->countItem($_POST['item_id'], $_POST['count']);
	}
}