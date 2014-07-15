<?php
class Controller_item extends Controller{
	
	private $model;
	
	function __construct(){
		parent::__construct();
		
		$this->model = new Model_item();
	}
	
	function action_main(){
		if( ($item = $this->model->getItem($_GET['item_id'])) != "Item not found"){
			echo $this->twig->render('itemView.html',array('item'=>$item));
		}else{
			Router::ErrorPage404();
		}
	}
	
	function action_edit(){
		if(!empty($_POST['add'])){
			$item = array('id'=>$_GET['item_id'],'title'=> $_POST['title'], 'description'=>$_POST['description'], 'brand'=> $_POST['brand'],
					'color'=> $_POST['color'], 'diagonal'=> $_POST['diagonal'],'price'=>$_POST['price'], 'lan' =>(empty($_POST['lan'])?'0':$_POST['lan']), 'image'=>$_FILES['image']);
			$this->model->updateItem($item);
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
		}else{
			if( ($item = $this->model->getItem($_GET['item_id'])) != "Item not found"){
				echo $this->twig->render('itemEdit.html',array('item'=>$item));
			}else{
				Router::ErrorPage404();
			
			}
		}
		
		
	}
	
	function action_add(){//(empty($_POST['lan'])?'0':$_POST['lan'])
		if(!empty($_POST['add'])){
		
			$item = array('title'=> $_POST['title'], 'description'=>$_POST['description'], 'brand'=> $_POST['brand'],
				'color'=> $_POST['color'], 'diagonal'=> $_POST['diagonal'],'price'=>$_POST['price'], 'lan' =>(empty($_POST['lan'])?'0':$_POST['lan']), 'image'=>$_FILES['image']);
			$this->model->addItem($item);
		}
		echo $this->twig->render('itemEdit.html',array());
	}
	
}