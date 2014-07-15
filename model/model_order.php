<?php
class Model_order extends Model{
	
	function __construct(){
		parent::__construct();
	}
	
	
	
	function confirm($data, $twig){
		$sum =0;
		for($i=1;$i<=$_SESSION['count'];$i++){
			$sum+= $_SESSION['items'][$i]['count'] * $_SESSION['items'][$i]['price'];
		}
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$message = $twig->render("message.html", array("user" => $data, "total"=>$sum));
		mail("admin@rez.zapto.org", "Buy", $message);
		unset($_SESSION['items']); unset($_SESSION['count']); unset($_SESSION['Gcount']);
		return json_encode(array("stat"=> "OK"));
	}
	
}