<?php
class Model_item extends Model{
	
	function __construct(){
		parent::__construct();
	}
	
	function getItem($id){
		$q = $this->db->prepare("SELECT * FROM globalItems WHERE id =?");
		$q->execute(array($id));
		
		if($res = $q->fetch(PDO::FETCH_ASSOC)){
			return $res;
		}else{
			return "Item not found";
		}
	}
	
	function addItem($item){
		$q = $this->db->prepare("INSERT INTO globalItems(id, title, brand, description, diagonal, lan,price, color, photo) 
													VALUES(NULL, :title, :brand, :description, :diagonal, :lan, :price, :color, :image )");
		foreach ($item as $key=>$val){
			if($key!="image"){
				$q->bindValue(":".$key, $val);
			}
		}
	if($item['image']['tmp_name']!=""){
			$finfo = new finfo(FILEINFO_MIME_TYPE);
			if (false === $ext = array_search(
					$finfo->file($item['image']['tmp_name']),
					array(
							'jpg' => 'image/jpeg',
							'png' => 'image/png',
							'gif' => 'image/gif',
					),
					true
			)) {
			
				echo 'Недопустимый формат файла. Только изображения. Перенаправление через 5 секунд.';
				exit(0);
			
			}
			$file = file_get_contents($item['image']['tmp_name']);
			$q->bindValue(":image", $file);
		}else{
			$q->bindValue(":image", null);
		}
	
		$q->execute();
	}
	
	function updateItem($item){
		$sql = "UPDATE globalItems SET title= :title, brand= :brand, description= :description, 
														diagonal= :diagonal, lan= :lan, color= :color," ;
		$file_flag = 0;
		if($item['image']['tmp_name']!=""){
			$sql.= " photo= :image,";
			$file_flag=1;
		}
		$q = $this->db->prepare( $sql." price= :price WHERE id= :id");
													
		foreach ($item as $key=>$val){
			if($key!="image"){
				if(isset($item[$key])){
					$q->bindValue(":".$key, $val);
				}else{
					$q->bindValue(":".$key, "");
				}
			}
		}
		
		if($file_flag == 1){
			if($item['image']['tmp_name']!=""){
				$finfo = new finfo(FILEINFO_MIME_TYPE);
				if (false === $ext = array_search(
						$finfo->file($item['image']['tmp_name']),
						array(
								'jpg' => 'image/jpeg',
								'png' => 'image/png',
								'gif' => 'image/gif',
						),
						true
				)) {
				
					echo 'Недопустимый формат файла. Только изображения. Перенаправление через 5 секунд.';
					exit(0);
				
				}
				$file = file_get_contents($item['image']['tmp_name']);
				$q->bindValue(":image", $file);
			}else{
				$q->bindValue(":image", null);
			}
		}
		
		$q->execute();
	
	}
	
}