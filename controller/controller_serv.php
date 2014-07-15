<?php
class Controller_serv extends Controller{
	private $model;
	
	function __construct(){
		parent::__construct();
		$this->model = new Model_serv();
	}
	
	function action_img(){
		header("Content-type: image/jpg;");
		$res = $this->model->getPhoto($_GET['id']);
		if($res != 'Not found'){
			echo $res;
		}
	}
	
	
	
}
?>