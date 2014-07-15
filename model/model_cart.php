<?php
class Model_cart extends Model{
	
	function __construct(){
		parent::__construct();
	}
	
	function addItem($id){
		if(empty($_SESSION['count'])){
			$_SESSION['count'] = 0;
		}
		
		$q = $this->db->prepare("SELECT id,brand,price,title FROM globalItems WHERE id = ?");
		$q->execute(array($id));
		
		$f = 0;
		$stat = "";
		if($res = $q->fetch(PDO::FETCH_ASSOC)){
			for($i =1; $i<=$_SESSION['count']; $i++){
				
				if($_SESSION['items'][$i]['id'] == $id){
					$_SESSION['items'][$i]['count']= $_SESSION['items'][$i]['count']+1;
					$f=1;

					break;
				}
				
			}
			if($f==0){
				$new_index = ++$_SESSION['count'];
				$_SESSION['items'][ $new_index ] = $res;
				$_SESSION['items'][ $new_index ]['count']= 1;

			}
			$global_count = 0;
			for($i =1; $i<=$_SESSION['count']; $i++){
					$global_count += $_SESSION['items'][$i]['count'];			
			}
			$_SESSION['Gcount']  = $global_count;
			$res = array("stat"=>"OK", "count"=>$global_count);
			return json_encode($res);
			
		}else{
			return "ERROR";
		}
		
	}
	
	function deleteItem($id){
		$f = 0;
		
		for($i=1;$i<=$_SESSION['count'];$i++){
			if($_SESSION['items'][$i]['id'] == $id){
				$f=1;
				$_SESSION['Gcount'] -= $_SESSION['items'][$i]['count'];
				for($j = $i; $j<$_SESSION['count'];$j++){
					$_SESSION['items'][$j] = $_SESSION['items'][$j+1];
				}
				
				unset($_SESSION['items'][$_SESSION['count']]);
				$_SESSION['count']--;
				if($_SESSION['count']==0){
					unset($_SESSION['items']);
				}
				break;
			}
		}
		
		if($f == 1){
			return json_encode(array("stat"=>"OK", 'count' => $_SESSION['Gcount']));
		}
	
	}
	
	function countItem($id, $count){
		$f = 0;
		for($i=1;$i<=$_SESSION['count'];$i++){
			if($_SESSION['items'][$i]['id'] == $id){
				$f=1;
				
				$_SESSION['Gcount'] += $count- $_SESSION['items'][$i]['count'];
				$_SESSION['items'][$i]['count'] = $count;
				break;
			}
		}
	
		if($f == 1){
			return json_encode(array("stat"=>"OK", "gcount"=>$_SESSION['Gcount']));
		}
	
	}
	
}