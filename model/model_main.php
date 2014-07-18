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
		$items = array();
		while($t = $q->fetch(PDO::FETCH_ASSOC)){
			array_push($items,$t);
			//echo var_dump($t);
		}
		//echo var_dump($res);
		$res['items'] = $items;
		$tmp = $this->db->prepare("SELECT COUNT(*) as count FROM globalItems");
		$tmp->execute(array($page));
		$tmp = $tmp->fetch(PDO::FETCH_ASSOC); //Количество оставшихся записей в бд, 
		$count = intval($tmp['count']) - $page*6+6;																		//для определения будут ли еще страницы.

		if($count>0){
			
			$res['pageLast'] = false;
		}else{
			$res['pageLast'] = true;
		}
		return $res;
		
	}
	
}