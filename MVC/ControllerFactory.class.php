<?php
namespace Fulbert\PedaFramework\MVC;

//use Fulbert\Stages\Controllers\MainController;

class ControllerFactory {
	
		//Attention , le nom du controller doit contenir le namspace complet.
		public static function create ($namespace,$controllerName, $action=null, $params=null){
			$nameController=$namespace.'\\'.$controllerName.'Controller';
			
			$myController=new $nameController($controllerName, $action,$params);
			
			return $myController;
		}
}

?>