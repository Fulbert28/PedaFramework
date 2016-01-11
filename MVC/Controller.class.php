<?php
class Controller {
	
	protected $_data;
	protected $_name;
	protected $_action;
	protected $_params;
	
	public function Controller($controllerName=null, $action=null, $params=null){
		
			$this->_name=$controllerName;
			$this->_params=$params;
			
			if(is_null($action)){
				//Action par defaut: index
				$this->getAction('index',$params);
			}
			else{
				$this->getAction($action,$params);
			}
			
			//var_dump($this);
	}
	
	
	public function getAction($action, $params=null){
		
		$namefunction=$action."Action";
		
		$this->_action=$action;
		
		$this->$namefunction($params);
	}
	
	/*
	 * Methode ShowView
	 * Respecter la convention de nommage des repertoires.
	 */
	public function showView(){
		
		$view="application/views/".$this->_name."/".$this->_action."View.phtml";
		//var_dump($view);
		
		include $view;
	}
}

?>