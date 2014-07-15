<?

class Router{
  
  private $controller_name = "main";
  private $action_name= "main";
  private $get_params = null;
  
  public $controller_path = "controller/";
  public $model_path = "model/";
  public $view_path = "view/";
  
  function __construct($request_uri){
  	
  	include "controller/Controller.php";
  	include "model/Model.php";
  	
	$url = explode("/", $request_uri);
	
    if(!empty($url[1])){
    	$tmp = explode("?",$url[1]);
    	$this->controller_name = $tmp[0];
    	 
    	if(!empty($tmp[1])){
    		$tmp = explode("&",$tmp[1]);
    		foreach ($tmp as $value){
    			$tmp1 = explode("=", $value);
    			$_GET[$tmp1[0]] = $tmp1[1];
    		}
    	}
    }
  	if(!empty($url[2])){
  		$tmp = explode("?",$url[2]);
     	$this->action_name = $tmp[0];
     	if(!empty($tmp[1])){
     		$tmp = explode("&",$tmp[1]);
     		foreach ($tmp as $value){
     			$tmp1 = explode("=", $value);
     			$_GET[$tmp1[0]] = $tmp1[1];
     		}
     	}
    }
    
    $this->model_name = "Model_" . $this->controller_name;
    $this->controller_name = "Controller_" . $this->controller_name;
    $controller_file = strtolower($this->controller_name).'.php';
    $this->action_name = "action_" . $this->action_name;
    $model_file = strtolower($this->model_name).'.php';
   
    if( file_exists($this->controller_path . $controller_file)){
    	require $this->controller_path . $controller_file ;
    }else{
    	Router::ErrorPage404();
    }
    
    if( file_exists($this->model_path . $model_file)){
    	require $this->model_path . $model_file ;
    }
    
    $controller = new $this->controller_name;
    $action = $this->action_name;
    if(method_exists($controller, $action)){
    	$controller->$action();
    }else{
    	Router::ErrorPage404();
    }
    
     
  }
  
  public static function ErrorPage404(){
  	
  	$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
  	header('HTTP/1.1 404 Not Found');
  	header("Status: 404 Not Found");
  	header('Location:'.$host.'404');
  }
  
}

?>