<?php
class Controller{
	public $twig;
	
	function __construct(){
		require_once 'view/Twig/Autoloader.php';
		Twig_Autoloader::register();
		$loader = new Twig_Loader_Filesystem('view/tmpl');
		$this->twig = new Twig_Environment($loader);
		if(empty($_SESSION['Gcount'])){
			$_SESSION['Gcount'] = 0;
		}
		$this->twig->addGlobal('session', $_SESSION);
	}
} 
?>