<?php
namespace Fulbert\PedaFramework\MVC;

class Layout {
	
	private $_file;
	private $_name;
	
	public function __construct($name){
		
		$folder="layouts";
		$this->_name=$name;
		
		$file=$name."/index.lay.php";
		
		$this->_file=$folder."/".$file;
	}
	
	public function show(){
		include $this->_file;
	}
	
	public function getName(){
		$folder="layouts";
		
		return $folder."/".$this->_name;
	}
}

?>