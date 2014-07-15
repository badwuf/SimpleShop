<?php
class Controller_404 extends Controller{
	function action_main(){
		header('Refresh:5; url=http://'.$_SERVER['HTTP_HOST'].'/');
		
		echo "Не найдено.";
	}
}