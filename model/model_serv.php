<?php
class Model_serv extends Model{
	
	function __construct(){
		parent::__construct();
	}
	
	function getPhoto($item_id){
		$q = $this->db->prepare("SELECT photo FROM globalItems WHERE id = ?");
		$q->execute(array($item_id));
		if($res = $q->fetch(PDO::FETCH_ASSOC)){
			return $res['photo'];
		}else{
			return "Not found.";
		}
		
	}
	
	
	
}