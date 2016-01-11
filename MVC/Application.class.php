<?php
class Application {
	
	private static $_layout;
	
	public static function getController($name,$action=null, $params=null){
		
		$mycontroller=ControllerFactory::create($name,$action,$params);
		
		return $mycontroller;
	}
	
	public static function setLayout($layoutname){
		
		$mylayout=new Layout($layoutname);
		
		Application::$_layout=$mylayout;
		
	}
	
	public static function getLayout(){
		return Application::$_layout;
	}
	
	public static function printLayoutName(){
		echo Application::$_layout->getName();
	}
	
	public static function initSession(){
		session_start();
	}
}

?>