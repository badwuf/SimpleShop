<?php 
class Controller_main extends Controller{
	
	private $model;
	
	function __construct(){
		parent::__construct();
		$this->model = new Model_main();
	}
	
	function action_main(){
		$page = empty($_GET['page']) ? 0 : $_GET['page'];
		$this->twig->addGlobal('page', $page);
		$res = $this->model->getItems($page);
		echo $this->twig->render('main.html', array('items'=>$res['items'], 'pageLast'=>$res['pageLast'])); 
	}
}
?>