<?php
class Controller_order extends Controller{
	
	private $model;
	
	function __construct(){
		parent::__construct();
		$this->model = new Model_order();
	}
	
	function action_main(){
		echo $this->twig->render('order.html', array());
	}
	
	function action_confirm(){
		echo $this->model->confirm(array('first_name' => $_POST['first_name'], 'last_name' => $_POST['last_name'],
																'address'=>$_POST['address'], 'email'=>$_POST['email']), $this->twig);
		echo "Заказ отправлен!";
		header('Refresh:3; url=http://'.$_SERVER['HTTP_HOST'].'/');
		//echo $this->twig->render('order.html', array());
	}
}