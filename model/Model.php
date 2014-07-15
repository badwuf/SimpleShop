<?php
class Model{
	public $db;
	function __construct(){
		$this->db = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "user", "password");
	}
}
?>
