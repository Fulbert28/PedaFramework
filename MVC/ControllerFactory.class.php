<?php
class ControllerFactory {
	
		public static function create ($controllerName, $action=null, $params=null){
			$nameController=$controllerName."Controller";
			
			$myController=new $nameController($controllerName, $action,$params);
			
			return $myController;
		}
}

?>