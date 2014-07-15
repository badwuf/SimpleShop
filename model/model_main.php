<?php
class Model_main extends Model{
	
	function __construct(){
		parent::__construct();
	}
	
function getItems($page = 0){
			
		$q = $this->db->prepare( "SELECT * FROM globalItems  LIMIT :page, 6");
		
		$page = (int)$page * 6; //По 6 товаров на страницу
		$q->bindValue(":page", (int)trim($page), PDO::PARAM_INT);
		
		$q->execute();
		$res = array();
		
		while($t = $q->fetch(PDO::FETCH_ASSOC)){
			array_push($res,$t);
			//echo var_dump($t);
		}
		//echo var_dump($res);
		return $res;
		
	}
	
}