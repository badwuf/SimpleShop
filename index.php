<?
header("Content-type: text/html; charset=utf-8");
session_start();
ini_set('display_errors', 1);
  error_reporting(E_ALL);
 
include "core/Router.php";


$router = new Router($_SERVER['REQUEST_URI']);

?>
